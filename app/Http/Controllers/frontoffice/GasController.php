<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\BranchInfo;
use App\Models\Category;
use App\Models\LanguageAvailable;
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
        $orderItem = OrderItem::where(['orders_number' => $orderNumber])->get();
        $orderTemp = OrderTemp::where(['orders_number' => $orderNumber])->first();

        if (count($orderItem) <= 0) {
            OrderTemp::where(['orders_number' => $orderNumber])->delete();
            return redirect('/');
        }

        $orderItem = DB::table('order_items')
                        ->select('order_items.*', 'products.*')
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->get();

        $totalPrice = 0;
        foreach ($orderItem as $key => $value) {
            $totalPrice += ($value->price * $value->quantity);
        }

        return view('pages.gas.cart', [
            'order_temp' => $orderTemp,
            'order_items' => $orderItem,
            'total_price' => $totalPrice,
            'cart_notify' => count($orderItem),
        ]);
    }
}
