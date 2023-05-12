<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product_category;
use App\Models\Product;
use App\Models\Category;
use App\Models\MemberAccount;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /* Profile */
    public function profileContent(Request $request)
    {
        $member = MemberAccount::where(['id' => auth()->guard('member')->id()])->first();
        return view('pages.profile.profile', [
            'member' => $member,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
        ]);
    }

    /* Information */
    public function informationContent(Request $request)
    {
        $title = Category::all();
        $member = MemberAccount::where(['id' => auth()->guard('member')->id()])->first();
        return view('pages.profile.information', [
            'title' => $title,
            'member' => $member,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
        ]);
    }

    /* Information Edit */
    public function informationEditContent(Request $request)
    {
        $category = $this->queryCategory(3);
        $banner = $this->queryBanner(10);

        return view('pages.profile.edit', [
            'banner' => $banner,
            'category' => $category,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
        ]);
    }

    /* Order History */
    public function orderHistoryContent(Request $request)
    {
        $status = OrderStatus::all();
        return view('pages.profile.orderhistory', data: [
            'status' => $status,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
        ]);
    }

    /* Order Detail Wash and Dry */
    public function orderDetailwashNdryContent(Request $request)
    {
        $title = Category::all();
        $status = OrderStatus::all();
        return view('pages.profile.washing', data: [
            'title' => $title,
            'status' => $status,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
        ]);
    }

    /* Order Detail Wash and Dry Receipt */
    public function orderReceipt(Request $request)
    {
        $category = $this->queryCategory(5);
        $payment = OrderPayment::where(['orders_number' => $request->orders_number])->first();
        $title = Category::all();
        return view('pages.profile.receipt', [
            'title' => $title,
            'payment' => $payment,
            'category' => $category,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),

        ]);
    }

    /* Order Detail Wash and Dry Evidence */
    public function orderEvidence(Request $request)
    {
        $category = $this->queryCategory(6);
        $order = Order::where(['orders_number' => $request->orders_number])->first();
        $title = Category::all();
        return view('pages.profile.washingevidence', [
            'title' => $title,
            'order' => $order,
            'category' => $category,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),

        ]);
    }

    /* Order Detail Vending and Cafe */
    public function orderDetailvendingNcafeContent(Request $request)
    {
        $title = Category::all();
        $status = OrderStatus::all();
        return view('pages.profile.foods', data: [
            'title' => $title,
            'status' => $status,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
        ]);
    }


    public function orderHistory(Request $request)
    {
        $infos = $this->getWebInfo('', $request->session()->get('language'));
        $webInfo = $this->infoSetting($infos);
        $member = Auth::guard('member')->user();
        $order = $this->getOrderHistory($member);
        return view('pages.profile.orderhistory', [
            'member' => $member,
            'order' => $order,
            'shipped_price' => (int)$webInfo->settings->delivery_price->value,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
        ]);
    }

    public function orderDetail(Request $request)
    {
        $category = $this->queryCategory(4);
        $language = $request->session()->get('language');
        $infos = $this->getWebInfo('', $request->session()->get('language'));
        $webInfo = $this->infoSetting($infos);

        $title = Category::all();
        $orderNumb = $request->order_numb;
        $order = $this->getOrderByOrderNumber($orderNumb);
        if (!$order) {
            return redirect('/');
        }
        if ($order->type_order == 'foods') {
            return view('pages.profile.foods', [
                'title' => $title,
                'order' => $order,
                'shipped_price' => (int)$webInfo->settings->delivery_price->value,
                'category' => $category,
                'content_language' => $this->getContentLanguage($request->session()->get('language')),
            ]);
        } else if ($order->type_order == "washing") {
            $order_items = $this->getOrderWashItemList($orderNumb, $language);
            $data = array();
            $totalPrice = 0;
            foreach ($order_items as $key => $value) {
                $totalPrice += $value->totalPrice;
                if (!isset($data[$value->cart_number])) {
                    $data[$value->cart_number] = array();
                }
                $value->title = str_replace(',', ', ', $value->title);
                array_push($data[$value->cart_number], $value);
            }
            return view('pages.profile.washing', [
                'title' => $title,
                'order' => $order,
                'orderItems' => $data,
                'subTotal' => $totalPrice,
                'shipped_price' => (int)$webInfo->settings->delivery_price->value,
                'category' => $category,
                'content_language' => $this->getContentLanguage($request->session()->get('language')),
            ]);
        }
    }



    /** Profile Api */
    public function onUpdateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_name' => 'required|string',
            'email' => 'required|email:rfc',
            'phone_number' => 'required|numeric',
            'line_id' => 'string|nullable',
            'address' => 'required|string',
            'address_location' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators("Invalid params", $validator->errors());
        }
        $files = $request->allFiles();

        try {
            DB::beginTransaction();
            $member = MemberAccount::where(['id' => $request->id])->first();
            if (!$member) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Member not found.'
                ], 404);
            }

            if (isset($files['profile_image'][0])) {
                /* Upload Thumbnail */
                $newFolder = "upload/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
                $image = $this->uploadImage($newFolder, $files['profile_image'][0], "", "");
                $member->profile_image = $image;
            }
            $member->member_name = $request->member_name;
            $member->email = $request->email;
            $member->line_id = $request->line_id;
            $member->phone_number = $request->phone_number;
            $member->address = ($request->address !== "null") ? $request->address : NULL;
            $member->address_location = ($request->address_location !== "null") ? $request->address_location : NULL;
            $member->save();
            DB::commit();
            return response([
                'message' => 'ok',
                'description' => 'Update member success.',
                'status' => true
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'description' => 'Something went wrong.',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function onUpdatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'c_password' => 'required|string|same:new_password',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators("Invalid params", $validator->errors());
        }

        try {
            DB::beginTransaction();
            $user = auth('member')->user();
            if (Hash::check($request->current_password, $user->password)) {
                $member = MemberAccount::where(['id' => $request->id])->first();
                if (!$member) {
                    return response([
                        'message' => 'error',
                        'status' => false,
                        'description' => 'Member not found.'
                    ], 404);
                }

                $member->password = Hash::make($request->new_password);
                $member->save();
                DB::commit();
                return response([
                    'message' => 'ok',
                    'description' => 'Update password success.',
                    'status' => true
                ], 200);
            } else {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Invalid password.'
                ], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'description' => 'Something went wrong.',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getOrderHistory($member)
    {
        try {
            if (!$member) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Member not found!'
                ], 404);
            }

            $sql = "SELECT orders.*, os.name as status_name, m.member_name,GROUP_CONCAT(oi.product_price) AS product_price, GROUP_CONCAT(oi.quantity) as quantity
                    FROM orders
                    LEFT JOIN order_items AS oi ON oi.orders_number = orders.orders_number
                    LEFT JOIN order_statuses AS os ON os.id = orders.status_id
                    LEFT JOIN member_accounts AS m ON m.id = orders.member_id
                    WHERE orders.member_id = :member_id AND orders.status_id != 1
                    GROUP BY oi.orders_number, orders.orders_number
                    ORDER BY orders.created_at DESC";

            $order = DB::select($sql, [':member_id' => $member->id]);

            return $order;
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getOrderByOrderNumber($orderNumb)
    {

        $orderDetail = Order::where(['orders_number' => $orderNumb])->first();
        if (!$orderDetail) {
            return null;
        }

        $order = Order::select(
            'orders.*',
            'order_statuses.name as status_name',
            'member_accounts.member_name',
            'branch_infos.name as branch_name',
            'order_payments.type as payment_type'
        )
            ->join('order_statuses', 'orders.status_id', 'order_statuses.id')
            ->join('member_accounts', 'orders.member_id', 'member_accounts.id')
            ->join('branch_infos', 'orders.branch_id', 'branch_infos.id')
            ->join('order_payments', 'order_payments.orders_number', 'orders.orders_number')
            ->where(['orders.orders_number' => $orderNumb, 'orders.type_order' => $orderDetail->type_order])
            ->first();
        $data = array();
        $totalPrice = 0;
        if ($orderDetail->type_order == "washing") {
            $order_items = $this->getOrderWashItemAdmin($orderNumb);
            foreach ($order_items as $key => $value) {
                $totalPrice += $value->totalPrice;
                $value->title = str_replace(',', ', ', $value->title);
                array_push($data, $value);
            }
        } else if ($orderDetail->type_order == "foods") {
            $order_items = $this->getOrderFoodsItemAdmin($orderNumb);
            foreach ($order_items as $key => $value) {
                $totalPrice += (int)$value->price * (int)$value->quantity;
                array_push($data, $value);
            }
        }
        $order->orderList = $data;
        $order->totalPrice = $totalPrice;
        return $order;
    }

    private function getOrderWashItemList($order_number, $language)
    {
        $member_id = auth()->guard('member')->id();
        $orderTemp = DB::select(
            "SELECT temps.id,
                            orders.details,
                            temps.orders_number,
                            temps.page_id,
                            temps.minutes_add,
                            orders.type_order,
                            temps.price_per_minutes,
                            temps.round_minutes,
                            temps.default_minutes,
                            temps.cart_number,
                            SUM(temps.price) as totalPrice,
                            GROUP_CONCAT(temps.product_title) as title
                    FROM orders
                    JOIN
                        (SELECT order_items .*,
                                products.price,
                                products.price_per_minutes,
                                products.round_minutes,
                                products.default_minutes,
                                products.title as product_title
                        FROM order_items
                        JOIN products
                        ON (order_items.product_id = products.id AND products.language = :language)
                        ) as temps
                    ON (orders.orders_number = temps.orders_number)
                    WHERE orders.type_order = 'washing' AND orders.member_id = :member_id AND orders.orders_number = :orders_number
                    GROUP BY temps.page_id, temps.orders_number, temps.cart_number",
            ['member_id' => $member_id, ':orders_number' => $order_number, ':language' => $language]
        );
        return $orderTemp;
    }
}
