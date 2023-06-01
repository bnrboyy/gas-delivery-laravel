<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\BankInfo;
use App\Models\BranchInfo;
use stdClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\LanguageAvailable;
use App\Models\Order;
use App\Models\OrderTemp;
use App\Models\ProductCategory;
use App\Models\ProductMoreDetail;

class VendingAndCafeController extends Controller
{
    /* Vending and Cafe */
    public function tankchangeOrdering(Request $req)
    {

        $lang_default = LanguageAvailable::where(['defaults' => 1])->first();
        $lang = $req->session()->get('language') ? $req->session()->get('language') : $lang_default->abbv_name;
        $branch = BranchInfo::get();
        $title = Category::whereIn('id', range('15', '16'))->get();
        $category = $this->queryCategory(14);
        $banner = $this->queryBanner(14);
        $language_available = LanguageAvailable::orderBy('defaults', 'desc')->get();
        $lang_active = LanguageAvailable::where(['abbv_name' => $lang])->first();

        $order = OrderTemp::where(['orders_number' => $req->session()->get('orders_number'), 'type_order' => 'foods'])->first();
        if ($order) {
            // return redirect('/foods/cart');
        }
        return view('pages.gas.tankchange', [
            'branch' => $branch,
            'title' => $title,
            'banner' => $banner,
            'category' => $category,
            'content_language' => $this->getContentLanguage($req->session()->get('language')),
            'language_available' => $language_available,
            'language_active' => $lang_active,
            'cart_notify' => 4,
        ]);
    }


    public function productDetails(Request $request) {

        return view('pages.gas.product-details', [
            'cart_notify' => 4,

        ]);
    }

    public function cartDetails(Request $request) {
        return view('pages.gas.cart', [
            'cart_notify' => 4,
        ]);
    }

    public function orderSummary(Request $request) {
        return view('pages.gas.order-summary', [
            'cart_notify' => 4,
        ]);
    }








    public function foodsMenu(Request $request)
    {
        $orderNumber = $request->session()->get('orders_number');
        if ($orderNumber === null) {
            $lastOrder = OrderTemp::where('ip_address', $request->ip())->first();
            if (!$lastOrder) {
                return redirect('/');
            }
            $orderNumber = $lastOrder->orders_number;
        }
        $language = $request->session()->get('language');
        $infos = $this->getWebInfo('', $language);
        $webInfo = $this->infoSetting($infos);
        $request->session()->put('orders_number', $orderNumber);
        $orderTemp = $this->getOrderFoodsTemp($request->ip(), $orderNumber, $language);
        $category = $this->queryCategory(15);
        $banner = $this->queryBanner(15);
        $product_cate = ProductCategory::where(['is_food' => 1, 'language' => $language])->get();
        $cate_id = (int)$request->cate_id;

        $hasCateSql = "";
        if ($cate_id != 0) {
            $hasCateSql = "WHERE (pc.id = " . $cate_id . " AND pc.is_food = 1 " . " AND pc.language = " . "'$language'" . " AND p.language = " . "'$language'" . ")";
        } else {
            $hasCateSql = "WHERE (pc.is_food = 1" . " AND pc.language = " . "'$language'" . " AND p.language = " . "'$language'"  . ")";
        }

        $sql = "SELECT p.* FROM product_categories AS pc
                INNER JOIN products AS p
                ON p.cate_id = pc.id
                " . $hasCateSql;

        $allFoodNDrink = DB::select($sql);

        $orderTemp = $this->getOrderFoodsTemp($request->ip(), $orderNumber, $language);
        $totalPrice = 0;
        $totalList = 0;
        foreach ($orderTemp as $key => $value) {
            $totalPrice += (int)$value->price * (int)$value->quantity;
            $totalList += (int)$value->quantity;
        }
        return view('pages.food.menu', [
            'banner' => $banner,
            'product_cate' => $product_cate,
            'category' => $category,
            'foodNDrink' => $allFoodNDrink,
            'total_list' => $totalList,
            'total_price' => $totalPrice,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
            'currency_symbol' => $webInfo->settings->currency_symbol->value,
        ]);
    }

    /* Food */
    public function foodsDetails(Request $req)
    {
        $language = $req->session()->get('language');
        $infos = $this->getWebInfo('', $language);
        $webInfo = $this->infoSetting($infos);

        if ($req->session()->get('orders_number') === null) {
            return redirect('/');
        }
        $product = Product::where('id', $req->food_id)->where('page_id', 15)->first();
        $microwave = ProductMoreDetail::where(['type' => 'Microwave'])->get();
        $sweetness = ProductMoreDetail::where(['type' => 'Sweetness'])->get();
        return view('pages.food.details', [
            'product' => $product,
            'microwave' => $microwave,
            'sweetness' => $sweetness,
            'content_language' => $this->getContentLanguage($req->session()->get('language')),
            'currency_symbol' => $webInfo->settings->currency_symbol->value,
        ]);
    }

    /* Vending and Cafe List */
    public function foodsCart(Request $request)
    {
        $language = $request->session()->get('language');
        $infos = $this->getWebInfo('', $language);
        $webInfo = $this->infoSetting($infos);

        if ($request->session()->get('orders_number') === null) {
            return redirect('/');
        }

        $orderTemp = $this->getOrderFoodsTemp($request->ip(), $request->session()->get('orders_number'), $language);
        if (count($orderTemp) == 0) {
            return redirect('/foods/menu');
        }
        $title = Category::all();
        $totalPrice = 0;
        foreach ($orderTemp as $key => $value) {
            $totalPrice += (int)$value->price * (int)$value->quantity;
        }
        return view('pages.food.cart', [
            'title' => $title,
            'total_list' => count($orderTemp),
            'total_price' => $totalPrice,
            'order_item' => $orderTemp,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
            'currency_symbol' => $webInfo->settings->currency_symbol->value,
        ]);
    }

    /* Vending and Cafe Summary */
    public function foodsPayment(Request $request)
    {
        $language = $request->session()->get('language');
        $infos = $this->getWebInfo('', $request->session()->get('language'));
        $webInfo = $this->infoSetting($infos);
        $branch = BranchInfo::get();
        $category = $this->queryCategory(13);
        $orderNumber = ($request->session()->get('orders_number') !== null) ? $request->session()->get('orders_number') : null;
        if (!$orderNumber) {
            return redirect('/profile/orderhistory');
        }
        $orderDetails = Order::select(
            'orders.*',
            'branch_infos.id as branch_id',
            'branch_infos.name as branch_name',
            'branch_infos.location as branch_location',
            'order_payments.type as type_payment',
            'order_payments.amount as payment_amount',
            'order_payments.time_pay as payment_time',
            'order_payments.slip_image',
            'order_payments.verified',
            'bank_infos.bank_name',
            'bank_infos.bank_account',
            'bank_infos.bank_number',
            'bank_infos.bank_image',
            'order_statuses.name as status_name'
        )
            ->leftJoin('order_payments', 'orders.orders_number', 'order_payments.orders_number')
            ->leftJoin('bank_infos', 'order_payments.bank_id', 'bank_infos.id')
            ->join('order_statuses', 'orders.status_id', 'order_statuses.id')
            ->join('branch_infos', 'orders.branch_id', 'branch_infos.id')
            ->where(['orders.member_id' => auth()->guard('member')->id(), 'orders.orders_number' => $orderNumber])
            ->first();
        if (!$orderDetails) {
            return redirect('/');
        }
        $order_items = $this->getOrderFoodsItem($request->session()->get('orders_number'), $language);
        // dd($order_items);
        if (count($order_items) == 0) {
            return redirect('/');
        }
        $totalPrice = 0;
        foreach ($order_items as $key => $value) {
            $totalPrice += (int)$value->price * (int)$value->quantity;
        }
        $bank_info = BankInfo::get();
        return view('pages.food.payment', [
            'branch' => $branch,
            'banks' => $bank_info,
            'category' => $category,
            'order_details' => $orderDetails,
            'order_items' => $order_items,
            'sub_total' => $totalPrice,
            'price_per_kilo' => (int)$webInfo->settings->price_per_kilo->value,
            'maximum_radius' => $webInfo->settings->maximum_radius->value,
            'content_language' => $this->getContentLanguage($request->session()->get('language')),
            'currency_symbol' => $webInfo->settings->currency_symbol->value,
        ]);
    }
}
