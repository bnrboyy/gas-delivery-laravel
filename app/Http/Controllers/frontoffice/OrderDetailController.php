<?php

namespace App\Http\Controllers\frontoffice;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCart;
use App\Models\OrderCartTemp;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\OrderTemp;
use App\Models\Product;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;

class OrderDetailController extends Controller
{
    public function onCreateOrderTemp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pickup_location' => 'required|string',
            'pickup_location_address' => 'required|string',
            'pickup_address_detail' => 'string|nullable',
            'drop_location' => 'required|string',
            'drop_location_address' => 'required|string',
            'drop_address_detail' => 'string|nullable',
            'phone_number' => 'required|string',
            'order_details' => 'string|nullable',
            'clothing_type_id' => 'numeric|required',
            'wash_or_dry_id' => 'numeric|required',
            'pickup_time' => 'required|string',
            'drop_time' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid params',
                'errorMessage' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $clothing = Product::where(['id' => $request->clothing_type_id])->first();
            $washOrDry = Product::where(['id' => $request->wash_or_dry_id])->first();
            if (!$clothing) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Product not found.'
                ], 404);
            }
            if (!$washOrDry) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Product not found.'
                ], 404);
            }
            $member = Auth::guard('member')->user();
            $orderNumber = "ORD-" . time() . random_int(10000, 99999);
            $orderTemp = OrderTemp::where(['orders_number' => $orderNumber])->first();
            $request->session()->put('orders_number', $orderNumber);

            if (!$orderTemp) {
                $temp = new OrderTemp();
                $temp->orders_number = $orderNumber;
                $temp->ip_address = $request->ip();
                $temp->member_id = $member ? $member->id : 0;
                $temp->branch_id = $request->branch_id;
                $temp->delivery_pickup = $request->pickup_location;
                $temp->delivery_pickup_address = $request->pickup_location_address;
                $temp->delivery_pickup_address_more = $request->pickup_address_detail;
                $temp->delivery_drop = $request->drop_location;
                $temp->delivery_drop_address = $request->drop_location_address;
                $temp->delivery_drop_address_more = $request->drop_address_detail;
                $temp->phone_number = $request->phone_number;
                $temp->details = $request->order_details;
                $temp->transaction_date = new DateTime();
                $temp->shipping_date = $request->drop_time;
                $temp->date_pickup = $request->pickup_time;
                $temp->date_drop = $request->drop_time;
                $temp->type_order = "washing";
                $temp->save();
            } else {
                OrderCartTemp::where('orders_number', $orderNumber)->delete();
                $orderTemp->member_id = $member ? $member->id : 0;
                $orderTemp->branch_id = $request->branch_id;
                $orderTemp->delivery_pickup = $request->pickup_location;
                $orderTemp->delivery_pickup_address = $request->pickup_location_address;
                $orderTemp->delivery_pickup_address_more = $request->pickup_address_detail;
                $orderTemp->delivery_drop = $request->drop_location;
                $orderTemp->delivery_drop_address = $request->drop_location_address;
                $orderTemp->delivery_drop_address_more = $request->drop_address_detail;
                $orderTemp->phone_number = $request->phone_number;
                $orderTemp->details = $request->order_details;
                $orderTemp->transaction_date = date('Ymd h:i:s');
                $orderTemp->shipping_date = $request->drop_time;
                $orderTemp->date_pickup = $request->pickup_time;
                $orderTemp->date_drop = $request->drop_time;
                $orderTemp->type_order = "washing";
                $orderTemp->save();
            }

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Confirm order success.'
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

    public function onCreateOrderWashTemp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'capacity_id' => 'numeric|required',
            'water_temp_id' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid params',
                'errorMessage' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $capacity = Product::where(['id' => $request->capacity_id, 'cate_id' => 3])->first();
            $waterTemp = Product::where(['id' => $request->water_temp_id, 'cate_id' => 4])->first();
            if (!$capacity) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Product not found.'
                ], 404);
            }
            if (!$waterTemp) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Product not found.'
                ], 404);
            }
            $orderNumber = $request->session()->get('orders_number');
            $cart_number = OrderCartTemp::where(['orders_number' => $orderNumber, 'page_id' => 10])->whereIn('product_cate_id', [3, 4])->orderBy('cart_number', 'DESC')->first();
            $current_cart = ($cart_number) ? ((int)$cart_number->cart_number) + 1 : 1;
            $orderTemp = OrderTemp::where(['orders_number' => $orderNumber])->first();
            if (!$orderTemp) {
                return response([
                    'message' => 'redirect',
                    'status' => true,
                    'description' => 'Redirect to washing.'
                ], 301);
            }

            OrderCartTemp::insert([
                [
                    'cart_number' => $current_cart,
                    'orders_number' => $orderNumber,
                    'product_id' => $capacity->id,
                    'product_title' => $capacity->title,
                    'product_cate_id' => $capacity->cate_id,
                    'page_id' => 10,
                ],
                [
                    'cart_number' => $current_cart,
                    'orders_number' => $orderNumber,
                    'product_id' => $waterTemp->id,
                    'product_title' => $waterTemp->title,
                    'product_cate_id' => $waterTemp->cate_id,
                    'page_id' => 10,
                ]
            ]);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Create order wash temp success.'
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

    public function onCreateOrderDryTemp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'numeric|required',
            'minutes_add' => 'numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid params',
                'errorMessage' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $capacity = Product::where(['id' => $request->product_id, 'cate_id' => 3])->first();
            if (!$capacity) {
                return response([
                    'message' => 'error',
                    'status' => false,
                    'description' => 'Product not found.'
                ], 404);
            }
            $orderNumber = $request->session()->get('orders_number');
            $cart_number = OrderCartTemp::where(['orders_number' => $orderNumber])->whereIn('product_cate_id', [3, 4, 5])->orderBy('cart_number', 'DESC')->first();
            // OrderCartTemp::where(['orders_number' => $orderNumber, 'product_id' => $request->product_id])->whereIn('product_cate_id', [3, 4, 5])->delete();
            $current_cart = ($cart_number) ? ((int)$cart_number->cart_number) : 1;

            $orderTemp = OrderTemp::where(['orders_number' => $orderNumber])->first();
            if (!$orderTemp) {
                return response([
                    'message' => 'redirect',
                    'status' => true,
                    'description' => 'Redirect to washing.'
                ], 301);
            }

            OrderCartTemp::where(['orders_number' => $orderNumber, 'page_id' => 11])->whereIn('product_cate_id', [3, 4, 5])->delete();

            OrderCartTemp::insert([
                [
                    'orders_number' => $orderNumber,
                    'cart_number' => $current_cart,
                    'product_id' => $capacity->id,
                    'product_title' => $capacity->title,
                    'product_cate_id' => $capacity->cate_id,
                    'minutes_add' => $request->minutes_add,
                    'page_id' => 11,
                ],
            ]);

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Create order wash temp success.'
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

    public function onDeleteOrderFoodsTemp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orders_number' => 'required|string',
            'product_id' => 'required|string',
            'cart_number' => 'required|string',
        ]);


        if ($validator->fails()) {
            return response([
                'status' => false,
                'message' => 'Invalid params',
                'errorMessage' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            OrderCartTemp::where(['orders_number' => $request->orders_number, 'product_id' => $request->product_id, 'cart_number' => $request->cart_number])->delete();

            $check_order = OrderCartTemp::where(['orders_number' => $request->orders_number])->first();
            if (!$check_order) {
                OrderTemp::where(['orders_number' => $request->orders_number])->delete();
            }

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Delete order food temp success.'
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

    public function onDeleteOrderTemp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orders_number' => 'required|string',
            'page_id' => 'required|string',
            'cart_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid params',
                'errorMessage' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            if ($request->page_id == 10) {
                OrderCartTemp::where(['orders_number' => $request->orders_number, 'cart_number' => $request->cart_number])->delete();
            } else {
                OrderCartTemp::where(['orders_number' => $request->orders_number, 'page_id' => $request->page_id, 'cart_number' => $request->cart_number])->delete();
            }
            $check_order = OrderCartTemp::where(['orders_number' => $request->orders_number])->first();
            if (!$check_order) {
                OrderTemp::where(['orders_number' => $request->orders_number])->delete();
            }
            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Delete order wash temp success.'
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
            $order_temp = OrderTemp::where(['orders_number' => $orderNumber, 'type_order' => 'washing'])->first();
            if (!$order_temp) {
                return response([
                    'message' => 'redirect',
                    'status' => true,
                    'description' => 'Redirect to menu'
                ], 301);
            }
            $order_items = $this->getOrderWashTemp($request->ip(), $language);
            $totalPrice = 0;
            foreach ($order_items as $key => $value) {
                $totalPrice += $value->totalPrice ; //คำนวณราคา  add dry
            }
            $cart_temp = OrderCartTemp::where(['orders_number' => $order_temp->orders_number])->get();
            OrderItem::where(['orders_number' => $order_temp->orders_number])->delete();
            foreach ($cart_temp as $item) {
                $product = Product::where(['id' => $item->product_id])->first();
                $new_item = new OrderItem();
                $new_item->orders_number = $order_temp->orders_number;
                $new_item->cart_number = $item->cart_number;
                $new_item->product_id = $product->id;
                $new_item->product_name = $product->title;
                $new_item->product_price = $product->price;
                $new_item->product_cate_id = $product->cate_id;
                $new_item->minutes_add = $item->minutes_add;
                $new_item->page_id = $item->page_id;
                $new_item->save();
            }
            Order::where(['orders_number' => $order_temp->orders_number])->delete();
            $new_order = new Order();
            $new_order->orders_number = $order_temp->orders_number;
            $new_order->member_id = auth()->guard('member')->id(); // must be logged in
            $new_order->branch_id = $order_temp->branch_id;
            $new_order->status_id = 1;
            $new_order->delivery_pickup = $order_temp->delivery_pickup;
            $new_order->delivery_pickup_address = $order_temp->delivery_pickup_address;
            $new_order->delivery_pickup_address_more = $order_temp->delivery_pickup_address_more;
            $new_order->delivery_drop = $order_temp->delivery_drop;
            $new_order->delivery_drop_address = $order_temp->delivery_drop_address;
            $new_order->delivery_drop_address_more = $order_temp->delivery_drop_address_more;
            $new_order->phone_number = $order_temp->phone_number;
            $new_order->details = $order_temp->details;
            $new_order->transaction_date = $order_temp->transaction_date;
            $new_order->shipping_date = $order_temp->shipping_date;
            $new_order->date_pickup = $order_temp->date_pickup;
            $new_order->date_drop = $order_temp->date_drop;
            $new_order->type_order = $order_temp->type_order;
            $new_order->delivery_price = 0;
            $new_order->total_price = $totalPrice;
            $new_order->language = $request->session()->get('language');
            $new_order->save();
            OrderCartTemp::where(['orders_number' => $order_temp->orders_number])->delete();
            OrderTemp::where(['orders_number' => $order_temp->orders_number])->delete();
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
            'pickup_location' => 'string|required',
            'drop_location' => 'string|required',
            'pickup_location_address' => 'string|required',
            'drop_location_address' => 'string|required',
            'pickup_address_detail' => 'string|nullable',
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

        try {
            DB::beginTransaction();
            $infos = $this->getWebInfo('', $request->session()->get('language'));
            $webInfo = $this->infoSetting($infos);
            $currency = $webInfo->settings->currency_symbol->value;
            $maximum_radius = $webInfo->settings->maximum_radius->value;
            $price_per_kilo = $webInfo->settings->price_per_kilo->value;
            if (($request->distance / 1000) > (int)$maximum_radius) {
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
                ]);
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
            $order->delivery_pickup = $request->pickup_location;
            $order->delivery_pickup_address = $request->pickup_location_address;
            $order->delivery_pickup_address_more = $request->pickup_address_detail;
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
}
