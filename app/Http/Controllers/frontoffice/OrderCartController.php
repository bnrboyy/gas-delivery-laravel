<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\BranchInfo;
use App\Models\Order;
use App\Models\OrderCartTemp;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\OrderTemp;
use App\Models\Product;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderCartController extends Controller
{
    public function onCreateOrderTempFood(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drop_address_detail' => 'string|nullable',
            'drop_location' => 'required|string',
            'drop_location_address' => 'required|string',
            'phone_number' => 'required|string',
            'branch_id' => 'required|numeric',
            'shipping_time' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            DB::beginTransaction();
            $member = Auth::guard('member')->user();
            $orderNumber = "ORD-" . time() . random_int(10000, 99999);
            $orderTemp = OrderTemp::where(['orders_number' => $orderNumber])->first();
            $request->session()->put('orders_number', $orderNumber);
            if (!$orderTemp) {
                $current_order = OrderTemp::where('ip_address', $request->ip())->first();
                if ($current_order) {
                    OrderCartTemp::where(['page_id' => 15, 'orders_number' => $current_order->orders_number])->delete();
                    $current_order->delete();
                }
                $temp = new OrderTemp();
                $temp->orders_number = $orderNumber;
                $temp->ip_address = $request->ip();
                $temp->member_id = ($member) ? $member->id : 0;
                $temp->branch_id = $request->branch_id;
                $temp->delivery_drop = $request->drop_location;
                $temp->delivery_drop_address = $request->drop_location_address;
                $temp->delivery_drop_address_more = $request->drop_address_detail;
                $temp->phone_number = $request->phone_number;
                $temp->transaction_date = new DateTime();
                $temp->shipping_date = new DateTime($request->shipping_time);
                $temp->type_order = "foods";
                $temp->save();
            } else {
                $orderTemp->member_id = ($member) ? $member->id : 0;
                $orderTemp->branch_id = $request->branch_id;
                $orderTemp->delivery_drop = $request->drop_location;
                $orderTemp->delivery_drop_address = $request->drop_location_address;
                $orderTemp->delivery_drop_address_more = $request->drop_address_detail;
                $orderTemp->phone_number = $request->phone_number;
                $orderTemp->transaction_date = new DateTime();
                $orderTemp->shipping_date = new DateTime($request->shipping_time);
                $orderTemp->type_order = "foods";
                $orderTemp->save();
            }

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Create order temp success.'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'description' => 'Something went wrong.',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function onCreateOrderCartTempFood(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'product_id' => 'required',
            'requirements' => 'string|nullable',
            'microwave_id' => 'numeric|nullable',
            'sweetness_id' => 'numeric|nullable',
            'quantity' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators("Invalid params", $validator->errors());
        }
        try {
            DB::beginTransaction();
            $product = Product::where('id', $req->product_id)->first();
            if (!$product) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Product not found.'
                ], 404);
            }

            $orderNumber = $req->session()->get('orders_number');
            $orderTemp = OrderTemp::where(['orders_number' => $orderNumber])->first();
            if (!$orderTemp) {
                return response([
                    'message' => 'redirect',
                    'status' => true,
                    'description' => 'Redirect to menu'
                ], 301);
            }

            $product_temp = OrderCartTemp::where(['orders_number' => $orderNumber, 'product_id' => $product->id])->orderBy('cart_number', 'DESC')->first();
            if ($product_temp) {
                OrderCartTemp::insert([
                    [
                        'orders_number' => $orderNumber,
                        'cart_number' => $product_temp->cart_number + 1,
                        'product_id' => $product->id,
                        'product_title' => $product->title,
                        'product_cate_id' => $product->cate_id,
                        'microwave_id' => ($req->microwave_id) ? $req->microwave_id : 0,
                        'sweetness_id' => ($req->sweetness_id) ? $req->sweetness_id : 0,
                        'requirements' => $req->requirements,
                        'page_id' => 15,
                        'quantity' => ($req->quantity) ? $req->quantity : 1,
                    ],
                ]);
            } else {
                OrderCartTemp::insert([
                    [
                        'orders_number' => $orderNumber,
                        'product_id' => $product->id,
                        'product_title' => $product->title,
                        'product_cate_id' => $product->cate_id,
                        'microwave_id' => ($req->microwave_id) ? $req->microwave_id : 0,
                        'sweetness_id' => ($req->sweetness_id) ? $req->sweetness_id : 0,
                        'requirements' => $req->requirements,
                        'page_id' => 15,
                        'quantity' => ($req->quantity) ? $req->quantity : 1,
                    ],
                ]);
            }

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Create order food cart success.'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function onUpdateCartItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orders_number' => 'required|string',
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'cart_number' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators("Invalid params", $validator->errors());
        }

        try {
            $cart_item = OrderCartTemp::where(['orders_number' => $request->orders_number, 'product_id' => $request->product_id, 'cart_number' => $request->cart_number])->first();
            if (!$cart_item) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Order not found.'
                ], 404);
            }
            $cart_item->quantity = $request->quantity;
            $cart_item->save();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Update quantity success.'
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'description' => 'Something went wrong.',
                'status' => false,
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function onConfirmCart(Request $request)
    {
        if (!auth()->guard('member')->check()) {
            return response([
                'message' => 'error',
                'description' => 'Unauthorized',
                'status' => false
            ], 401);
        }

        try {
            DB::beginTransaction();
            $language = $request->session()->get('language');
            $orderNumber = $request->session()->get('orders_number');
            $order_temp = OrderTemp::where(['orders_number' => $orderNumber, 'type_order' => 'foods'])->first();
            if (!$order_temp) {
                return response([
                    'message' => 'redirect',
                    'status' => true,
                    'description' => 'Redirect to menu'
                ], 301);
            }
            $order_items = $this->getOrderFoodsTemp($request->ip(), $orderNumber, $language);
            $totalPrice = 0;
            foreach ($order_items as $key => $value) {
                $totalPrice += (int)$value->price * (int)$value->quantity;
            }
            OrderItem::where(['orders_number' => $order_temp->orders_number])->delete();
            $cart_temp = OrderCartTemp::where(['orders_number' => $order_temp->orders_number])->get();
            foreach ($cart_temp as $item) {
                $product = Product::where(['id' => $item->product_id])->first();
                $new_item = new OrderItem();
                $new_item->orders_number = $order_temp->orders_number;
                $new_item->cart_number = $item->cart_number;
                $new_item->product_id = $product->id;
                $new_item->quantity = $item->quantity;
                $new_item->product_name = $product->title;
                $new_item->product_price = $product->price;
                $new_item->product_cate_id = $product->cate_id;
                $new_item->microwave_id = $item->microwave_id;
                $new_item->sweetness_id = $item->sweetness_id;
                $new_item->minutes_add = $item->minutes_add;
                $new_item->page_id = $item->page_id;
                $new_item->verified = true;
                $new_item->save();
            }
            Order::where(['orders_number' => $order_temp->orders_number])->delete();
            $new_order = new Order();
            $new_order->orders_number = $order_temp->orders_number;
            $new_order->member_id = auth()->guard('member')->id(); // must be logged in
            $new_order->branch_id = $order_temp->branch_id;
            $new_order->status_id = 1;
            $new_order->delivery_drop = $order_temp->delivery_drop;
            $new_order->delivery_drop_address = $order_temp->delivery_drop_address;
            $new_order->delivery_drop_address_more = $order_temp->delivery_drop_address_more;
            $new_order->phone_number = $order_temp->phone_number;
            $new_order->transaction_date = $order_temp->transaction_date;
            $new_order->shipping_date = $order_temp->shipping_date;
            $new_order->date_drop = $order_temp->date_drop;
            $new_order->type_order = $order_temp->type_order;
            $new_order->delivery_price = 0;
            $new_order->total_price = $totalPrice;
            $new_order->language = $request->session()->get('language');
            $new_order->save();
            OrderTemp::where(['orders_number' => $order_temp->orders_number])->delete();
            OrderCartTemp::where(['orders_number' => $order_temp->orders_number])->delete();
            DB::commit();

            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Confirm order wash temp success.'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'description' => 'Something went wrong.',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function onConfirmOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drop_location' => 'string|required',
            'drop_location_address' => 'string|required',
            'drop_address_detail' => 'string|nullable',
            'phone_number' => 'string|required',
            'branch_id' => 'numeric|required',
            'payment_type' => 'string|required',
            'distance' => 'numeric|required'
        ]);
        $files = $request->allFiles();

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid params',
                'errorMessage' => $validator->errors()
            ], 422);
        }
        $orderNumber = $request->session()->get('orders_number');
        if (!auth('member')->check()) {
            return response([
                'message' => 'redirect',
                'status' => true,
                'description' => 'Redirect to Login'
            ], 301);
        }

        try {
            DB::beginTransaction();
            $infos = $this->getWebInfo('', $request->session()->get('language'));
            $webInfo = $this->infoSetting($infos);
            $currency = $webInfo->settings->currency_symbol->value;
            $maximum_radius = $webInfo->settings->maximum_radius->value;
            $price_per_kilo = $webInfo->settings->price_per_kilo->value;
            if(($request->distance / 1000) > (int)$maximum_radius){
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => "Out of area for delivery ($maximum_radius km)."
                ], 400);
            }

            $order = Order::where(['orders_number' => $orderNumber])->first();
            if (!$order) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Order not found.'
                ], 404);
            }

            $slip_image = "";
            if (isset($files['slip_image'][0])) {
                /* Upload Thumbnail */
                $newFolder = "upload/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
                $slip_image = $this->uploadImage($newFolder, $files['slip_image'][0], "", "", "");
            }

            $delivery_price = (int)$price_per_kilo * ceil($request->distance / 1000);
            $order->status_id = 2;
            $order->branch_id = $request->branch_id;
            $order->delivery_drop = $request->drop_location;
            $order->delivery_drop_address = $request->drop_location_address;
            $order->delivery_drop_address_more = $request->drop_address_detail;
            $order->phone_number = $request->phone_number;
            $order->currency = $currency;
            $order->delivery_price = $delivery_price;
            $order->distance = $request->distance / 1000;
            $order->save();

            OrderPayment::insert([
                'type' => $request->payment_type,
                'orders_number' => $order->orders_number,
                'time_pay' => new DateTime(),
                'slip_image' => $slip_image,
            ]);

            $request->session()->forget('orders_number');

            /* Send line message */
            // $this->sendLineMessage($order);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Create order success.'
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'status' => false,
                'description' => $e->getMessage()
            ], 500);
        }
    }

    public function onChangeBranch(Request $request)
    {
        $branch_id = $request->id;
        $orderNumber = $request->session()->get('orders_number');
        $order = Order::where('orders_number', $orderNumber)->first();
        if(!$order) {
            return response([
                'message' => 'error',
                'description' => 'order not found',
                'status' => false
            ], 404);
        }
        $order->branch_id = $branch_id;
        $order->save();
        return response([
            'message' => 'ok',
            'description' => 'update branch success.',
            'status' => true
        ], 200);
    }
}
