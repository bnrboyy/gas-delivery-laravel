<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function getMap(Request $request){

        $orderNumber = $request->session()->get('orders_number');
        $orderItem = OrderItem::where(['orders_number' => $orderNumber])->get();
        $infos = $this->getWebInfo('', 'th');
        $webInfo = $this->infoSetting($infos);
        return view('pages.map-system.map', [
            'maximum_radius' => $webInfo->settings->maximum_radius->value,
            'branch_location' => $webInfo->settings->branch_location->value,
            'cart_notify' => count($orderItem),
        ]);
    }

    public function test(){
        $order = Order::first();
        if(!$order){
            return response([
                'message' => 'error',
                'description' => 'order not found.'
            ], 404);
        }
        $this->notify_message($order);
        return response([
            'message' => 'ok',
            'description' => 'send message success.'
        ], 200);
    }
}
