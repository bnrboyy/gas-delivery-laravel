<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\BankInfo;
use App\Models\BranchInfo;
use App\Models\LanguageAvailable;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderTemp;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Response;

class WashAndDryController extends Controller
{
    /* Wash and Dry */
    public function washOrdering(Request $req)
    {
        $language = $this->getCurrentLanguage($req->session()->get('language'));
        $branch = BranchInfo::get();
        $category = $this->queryCategory(9);
        $orderTemp = OrderTemp::where('ip_address', $req->ip())->first();

        $clothingTypeTitle = ProductCategory::where('id', 1)->first();
        $washOrDryTitle = ProductCategory::where('id', 2)->first();
        $clothingType = Product::where(['page_id' => 9, 'cate_id' => 1, 'language' => $language])->get();
        $washOrDry = Product::where(['page_id' => 9, 'cate_id' => 2, 'language' => $language])->get();

        $order = OrderTemp::where(['orders_number' => $req->session()->get('orders_number'), 'type_order' => 'washing'])->first();
        if($order){
            // return redirect('/washing/cart');
        }

        return view('pages.washing.ordering', [
            'branch' => $branch,
            'category' => $category,
            'washOrDry' => $washOrDry,
            'clothingType' => $clothingType,
            'orderTemp' => $orderTemp,
            'washOrDryTitle' => $washOrDryTitle,
            'clothingTypeTitle' => $clothingTypeTitle,
            'content_language' => $this->getContentLanguage($language),
        ]);
    }

    /* Washing */
    public function washingContent(Request $request)
    {
        if($request->session()->get('orders_number') === null){
            return redirect('/');
        }
        $language = $this->getCurrentLanguage($request->session()->get('language'));
        $infos = $this->getWebInfo('', $language);
        $webInfo = $this->infoSetting($infos);
        $category = $this->queryCategory(10);
        $capacityTitle = ProductCategory::where('id', 3)->first();
        $waterTempTitle = ProductCategory::where('id', 4)->first();
        $capacity = Product::where(['page_id' => 10, 'cate_id' => 3, 'language' => $language])->get();
        $waterTemp = Product::where(['page_id' => 10, 'cate_id' => 4, 'language' => $language])->get();

        $orderTemp = $this->getOrderWashTemp($request->ip(), $language);

        $totalPrice = 0;
        $addMinutesDry = 0;
        foreach ($orderTemp as $key => $value) {
            if ($value->minutes_add && $value->round_minutes !== 0) {
                $addMinutesDry = ($value->minutes_add/$value->round_minutes)*$value->price_per_minutes;
            }
            $totalPrice += (int)$value->totalPrice + $addMinutesDry;
        }
        return view('pages.washing.washing', [
            'currency_symbol' => $webInfo->settings->currency_symbol->value,
            'category' => $category,
            'capacity' => $capacity,
            'waterTemp' => $waterTemp,
            'capacityTitle' => $capacityTitle,
            'waterTempTitle' => $waterTempTitle,
            'total_list' => count($orderTemp),
            'total_price' => $totalPrice,
            'content_language' => $this->getContentLanguage($language),
        ]);
    }

    /* Drying */
    public function dryingContent(Request $request)
    {
        if($request->session()->get('orders_number') === null){
            return redirect('/');
        }
        $infos = $this->getWebInfo('', $request->session()->get('language'));
        $webInfo = $this->infoSetting($infos);

        $language = $this->getCurrentLanguage($request->session()->get('language'));
        $category = $this->queryCategory(11);
        $capacityTitle = ProductCategory::where('id', 3)->first();
        $dryingTimeTitle = ProductCategory::where('id', 5)->first();
        $capacity = Product::where(['page_id' => 11, 'cate_id' => 3, 'language' => $language])->get();
        // $currentWashing = OrderItem::where('orders_number', $request->session()->get('orders_number'))->first();

        $orderTemp = $this->getOrderWashTemp($request->ip(), $language);
        $totalPrice = 0;
        foreach ($orderTemp as $key => $value) {
            $totalPrice += (int)$value->totalPrice;
        }
        return view('pages.washing.drying', [
            'currency_symbol' => $webInfo->settings->currency_symbol->value,
            'webInfo' => $webInfo,
            'category' => $category,
            'capacityTitle' => $capacityTitle,
            'dryingTimeTitle' => $dryingTimeTitle,
            'capacity' => $capacity,
            'total_list' => count($orderTemp),
            'total_price' => $totalPrice,
            'content_language' => $this->getContentLanguage($language),
        ]);
    }

    /* Wash and Dry List */
    public function washingCart(Request $request)
    {
        if($request->session()->get('orders_number') === null){
            return redirect('/');
        }
        $language = $this->getCurrentLanguage($request->session()->get('language'));
        $infos = $this->getWebInfo('', $language);
        $webInfo = $this->infoSetting($infos);
        $orderTemp = $this->getOrderWashTemp($request->ip(), $language);
        if (count($orderTemp) == 0) {
            // return redirect('/');
        }
        $category = $this->queryCategory(12);
        $data = array();
        $totalPrice = 0;
        foreach ($orderTemp as $key => $value) {
            if (!isset($data[$value->cart_number])) {
                $data[$value->cart_number] = array();
            }
            $value->title = str_replace(",", ", ", $value->title);
            if ($value->minutes_add && $value->round_minutes !== 0) {
                $value->totalPrice = $value->totalPrice + ($value->minutes_add/$value->round_minutes)*$value->price_per_minutes ;
            }
            $totalPrice += $value->totalPrice;
            array_push($data[$value->cart_number], $value);
        }

        return view('pages.washing.cart', [
            'currency_symbol' => $webInfo->settings->currency_symbol->value,
            'category' => $category,
            'order_temp' => $data,
            'total_list' => count($orderTemp),
            'total_price' => $totalPrice,
            'content_language' => $this->getContentLanguage($language),
        ]);
    }

    /* Wash and Dry Summary */
    public function washingPayment(Request $request)
    {
        $language = $this->getCurrentLanguage($request->session()->get('language'));
        $infos = $this->getWebInfo('', $language);
        $webInfo = $this->infoSetting($infos);
        $branch = BranchInfo::get();
        $category = $this->queryCategory(13);
        $orderNumber = ($request->session()->get('orders_number') !== null)?$request->session()->get('orders_number'):null;
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
        $order_items = $this->getOrderWashItem($orderNumber, $language);
        if (count($order_items) == 0) {
            return redirect('/');
        }
        $data = array();
        $totalPrice = 0;
        foreach ($order_items as $key => $value) {
            if (!isset($data[$value->cart_number])) {
                $data[$value->cart_number] = array();
            }
            $value->title = str_replace(",", ", ", $value->title);
            if ($value->minutes_add && $value->round_minutes !== 0) {
                $value->totalPrice = $value->totalPrice + ($value->minutes_add/$value->round_minutes)*$value->price_per_minutes;
            }
            $totalPrice += $value->totalPrice;
            array_push($data[$value->cart_number], $value);
        }
        $bank_info = BankInfo::get();
        return view('pages.washing.payment', [
            'currency_symbol' => $webInfo->settings->currency_symbol->value,
            'branch' => $branch,
            'banks' => $bank_info,
            'category' => $category,
            'order_details' => $orderDetails,
            'order_items' => $data,
            'sub_total' => $totalPrice,
            'price_per_kilo' => (int)$webInfo->settings->price_per_kilo->value,
            'maximum_radius' => $webInfo->settings->maximum_radius->value,
            'content_language' => $this->getContentLanguage($language),
            'currency_symbol' => $webInfo->settings->currency_symbol->value,
        ]);
    }
}
