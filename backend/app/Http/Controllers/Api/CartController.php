<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookUser;
use App\Models\CourseUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * @throws \Exception
     */
    public function add(Request $request)
    {
        $carts = $request->all();
        $user = Auth::user();
        $courses = array_filter($carts, function ($item) {
            return $item['type_product'] == 2 ;
        });

        $books = array_filter($carts, function ($item) {
            return $item['type_product'] == 1 ;
        });

        try {
            DB::beginTransaction();
                foreach ($courses as $item) {
                    unset($item['type_product']);
                    DB::table('course_users')->updateOrInsert([
                        'user_id' => optional($user)->id,
                        'course_id' => $item['course_id'],
                        'status'   => 1,
                    ], array_merge(
                        $item,
                        [
                            'user_id' => optional($user)->id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    ));
                }

                foreach ($books as $item) {
                    unset($item['type_product']);
                    DB::table('book_users')->updateOrInsert([
                        'user_id' => optional($user)->id,
                        'book_id' => $item['book_id'],
                        'status'   => 1,
                    ], array_merge($item,
                        [
                            'user_id' => optional($user)->id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ])
                    );
                }
            DB::commit();
            return response()->json(['statusCode' => 201, 'message' => 'Thêm sản phẩm vào giỏ hàng thành công']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['statusCode' => 400, 'message' => $ex->getMessage()]);
        }
    }

    public function listCartByUser()
    {
        $user = Auth::user();
        $courses = CourseUser::query()
            ->where('user_id', optional($user)->id)
            ->where('status', 1)
            ->get()
            ->toArray();
        $books = BookUser::query()
            ->where('user_id', optional($user)->id)
            ->where('status', 1)
            ->get()
            ->toArray();
        return array_merge($courses, $books);
    }

    public function payCart()
    {
        try {
            DB::beginTransaction();
            $user = User::query()->find(Auth::user()->id);
            $courses = CourseUser::query()
                ->where('user_id', optional($user)->id)
                ->where('status', 1);

            $books = BookUser::query()
                ->where('user_id', optional($user)->id)
                ->where('status', 1);

            $sum = $courses->sum('sum_price') + $books->sum('sum_price');;
            if ($user->price < $sum) {
                return response()->json(['statusCode' => 400, 'message' => 'Số tiền trong tài khoản không đủ để thanh toán,vui lòng nạp thêm tiền !']);
            }

            $user->price = $user->price - $sum;
            $user->save();
            $courses->update(['status' => 2]);
            $books->update(['status' => 2]);
            // $meta_course = $courses->with('courses')->get();
            // dd($meta_course);
            DB::commit();
            return response()->json(['statusCode' => 200, 'message' => 'Thanh toán thành công']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['statusCode' => 400, 'message' => $ex->getMessage()]);
        }
    }
}
