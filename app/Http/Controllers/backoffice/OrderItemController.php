<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Order_item;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    public function index(Request $req)
    {
        $orderItem = OrderItem::all();
        // dd($orderItem);
        return $orderItem;
    }

    public function addItem($id)
    {
        $order = OrderItem::where('id', $id)->get()->first();
        // dd($order);
        return $order;
    }


}
