<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\BranchInfo;
use App\Models\Category;
use App\Models\LanguageAvailable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTemp;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GasController extends Controller
{
    public function tankChangeContent(Request $request)
    {
        $products = Product::where(['cate_id' => 1, 'display' => 1])->get();
        $orderNumber = $request->session()->get('orders_number');
        $orderItem = OrderItem::where(['orders_number' => $orderNumber])->get();

        $lang_default = LanguageAvailable::where(['defaults' => 1])->first();
        $lang = $request->session()->get('language') ? $request->session()->get('language') : $lang_default->abbv_name;
        $language_available = LanguageAvailable::orderBy('defaults', 'desc')->get();
        $lang_active = LanguageAvailable::where(['abbv_name' => $lang])->first();


        return view('pages.gas.tankchange', [
            'products' => $products,
            'language_available' => $language_available,
            'language_active' => $lang_active,
            'cart_notify' => count($orderItem),
        ]);
    }

    public function orderingContent(Request $request)
    {
        $products = Product::where(['cate_id' => 1, 'display' => 1])->get();
        $orderNumber = $request->session()->get('orders_number');
        $orderItem = OrderItem::where(['orders_number' => $orderNumber])->get();

        return view('pages.gas.ordering', [
            'products' => $products,
            'cart_notify' => count($orderItem),
        ]);
    }

    public function getProductById(Request $request)
    {

        $orderNumber = $request->session()->get('orders_number');
        $orderItem = OrderItem::where(['orders_number' => $orderNumber])->get();

        $data = Product::where(['id' => $request->product_id, 'display' => 1])->first();
        if (!$data) {
            return response([
                'message' => 'error',
                'description' => 'Product not found!'
            ], 404);
        }


        return view('pages.gas.product-details', [
            'data' => $data,

            'cart_notify' => count($orderItem),

        ]);
    }

    public function cartDetails(Request $request)
    {
        $orderNumber = $request->session()->get('orders_number');
        $orderItem = OrderItem::where('orders_number', $orderNumber)->get();
        $orderTemp = OrderTemp::where(['orders_number' => $orderNumber])->first();

        if (count($orderItem) <= 0) {
            OrderTemp::where(['orders_number' => $orderNumber])->delete();
            return redirect('/');
        }

        $orderItemList = DB::table('order_items')
            ->select('order_items.*', 'products.title', 'products.cate_id', 'products.details', 'products.more_details', 'products.price', 'products.display', 'products.thumbnail_link')
            ->where('order_items.orders_number', '=', $orderNumber)
            ->leftjoin('products', 'order_items.product_id', '=', 'products.id')
            ->orderBy('order_items.id', 'desc')
            ->get();


        $totalPrice = 0;
        foreach ($orderItemList as $key => $value) {
            $totalPrice += ($value->price * $value->quantity);
        }

        return view('pages.gas.cart', [
            'order_temp' => $orderTemp,
            'order_items' => $orderItemList,
            'total_price' => $totalPrice,
            'cart_notify' => count($orderItem),
        ]);
    }

    public function orderSummary(Request $request)
    {
        $orderNumber = $request->session()->get('orders_number');
        $orderItem = OrderItem::where(['orders_number' => $orderNumber])->get();
        $orderTemp = OrderTemp::where(['orders_number' => $orderNumber])->first();

        $infos = $this->getWebInfo('', 'th');
        $webInfo = $this->infoSetting($infos);

        $orderItemList = DB::table('order_items')
            ->select('order_items.*', 'products.title', 'products.cate_id', 'products.details', 'products.more_details', 'products.price', 'products.display', 'products.thumbnail_link')
            ->where('order_items.orders_number', '=', $orderNumber)
            ->leftjoin('products', 'order_items.product_id', '=', 'products.id')
            ->orderBy('order_items.id', 'desc')
            ->get();

        if (count($orderItem) <= 0) {
            OrderTemp::where(['orders_number' => $orderNumber])->delete();
            return redirect('/');
        }

        $totalPrice = 0;
        foreach ($orderItemList as $key => $value) {
            $totalPrice += ($value->price * $value->quantity);
        }
        return view('pages.gas.order-summary', [
            'order_temp' => $orderTemp,
            'cart_notify' => count($orderItem),
            'order_items' => $orderItemList,
            'total_price' => $totalPrice,
            'delivery_price' => $webInfo->settings->delivery_price->value,
            'price_per_kilo' => (int)$webInfo->settings->price_per_kilo->value,
            'maximum_radius' => $webInfo->settings->maximum_radius->value,

        ]);
    }

    public function searchOrder(Request $request)
    {

        $orderNumber = $request->session()->get('orders_number');
        $orderItem = OrderItem::where(['orders_number' => $orderNumber])->get();

        $phone_number = $request->phone;

        $orderDetails = Order::where(['phone_number' => $phone_number])->orWhere(['second_phone_number' => $phone_number])->orderBy('id', 'DESC')->get();

        foreach ($orderDetails as $key => $value) {
            if ($value->status_id == 2) {
                $value->order_status = "รอคำยืนยันจากร้าน";
            } else if ($value->status_id == 3) {
                $value->order_status = "กำลังดำเนินการ";
            } else if ($value->status_id == 4) {
                $value->order_status = "เสร็จสิ้น";
            } else if ($value->status_id == 5) {

                $value->order_status = "ไม่สำเร็จ";
            }

            $value->order_items = DB::select(
                "SELECT oi.*, p.title AS product_name , p.thumbnail_link AS product_img FROM order_items AS oi
                                                LEFT JOIN products AS p ON p.id = oi.product_id
                                                WHERE oi.orders_number = :orders_number
                                                ORDER BY oi.id DESC",
                ["orders_number" => $value->orders_number]
            );
        }

        return view('pages.gas.search-order', [
            'order_details' => $orderDetails,
            'cart_notify' => count($orderItem),

        ]);
    }
}
