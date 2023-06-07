<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\OrderTemp;
use App\Models\Product;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function createOrderTemp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'p_id' => 'required',
            'quantity' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }
        try {
            DB::beginTransaction();
            $orderNumbSession = $request->session()->get('orders_number');
            $orderNumber = $orderNumbSession ? $orderNumbSession : "ORD-" . time() . random_int(10000, 99999);
            $request->session()->put('orders_number', $orderNumber);



            $orderTemp = OrderTemp::where(['orders_number' => $orderNumber])->first();
            $product = Product::where(['id' => $request->p_id])->first();
            $orderItem = new OrderItem();

            if (!$product) {
                return response([
                    'message' => 'error',
                    'errorMessage' => 'Product not found!'
                ], 404);
            }

            if (!$orderTemp) {

                $temp = new OrderTemp();
                $temp->orders_number = $orderNumber;
                $temp->ip_address = $request->ip();
                $temp->transaction_date = new DateTime();
                $temp->save();

                $orderItem->orders_number = $orderNumber;
                $orderItem->product_id = $request->p_id;
                $orderItem->product_price = $product->price;
                $orderItem->product_cate_id = $product->cate_id;
                $orderItem->requirements = $request->requirements;
                $orderItem->quantity = $request->quantity;
                $orderItem->save();

                DB::commit();
                return response([
                    'message' => 'ok',
                    'status' => true,
                    'description' => 'Create order temp success.'
                ], 201);
            } else {
                $orderTemp->transaction_date = new DateTime();
                $orderTemp->save();

                $orderItem->orders_number = $orderNumber;
                $orderItem->product_id = $request->p_id;
                $orderItem->product_price = $product->price;
                $orderItem->product_cate_id = $product->cate_id;
                $orderItem->requirements = $request->requirements;
                $orderItem->quantity = $request->quantity;
                $orderItem->save();


                DB::commit();
                return response([
                    'message' => 'ok',
                    'status' => true,
                    'description' => 'Update order temp success.'
                ], 201);
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

    public function onDeleteOrderItem(Request $request)
    {
        try {
            DB::beginTransaction();
            OrderItem::where(['orders_number' => $request->ordernumber, 'product_id' => $request->pid, 'id' => $request->id])->delete();

            DB::commit();
            return response([
                'message' => 'ok',
                'description' => 'Delete order item success.',
                'status' => true,
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

    // public function decrementItem(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $item = OrderItem::where('id', $request->id)->first();
    //         if (!$item) {
    //             return response([
    //                 'message' => 'error',
    //                 'description' => 'order not found!'
    //             ], 404);
    //         }
    //         $item->quantity -= 1;
    //         $item->save();

    //         DB::commit();
    //         return response([
    //             'message' => 'ok',
    //             'description' => 'Decrement item success.',
    //             'status' => true,
    //         ], 200);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response([
    //             'message' => 'error',
    //             'status' => false,
    //             'description' => 'Something went wrong.',
    //             'errorMessage' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function incrementItem(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $item = OrderItem::where('id', $request->id)->first();
    //         if (!$item) {
    //             return response([
    //                 'message' => 'error',
    //                 'description' => 'order not found!'
    //             ], 404);
    //         }
    //         $item->quantity += 1;
    //         $item->save();

    //         DB::commit();
    //         return response([
    //             'message' => 'ok',
    //             'description' => 'Increment item success.',
    //             'status' => true,
    //         ], 200);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         return response([
    //             'message' => 'error',
    //             'status' => false,
    //             'description' => 'Something went wrong.',
    //             'errorMessage' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function updateQuantity(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = OrderItem::where('id', $request->id)->first();
            if (!$item) {
                return response([
                    'message' => 'error',
                    'description' => 'order not found!'
                ], 404);
            }
            $item->quantity = $request->quantity;
            $item->save();

            DB::commit();
            return response([
                'message' => 'ok',
                'description' => 'Update item quantity success.',
                'status' => true,
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
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'drop_location' => 'string|required',
            'drop_address' => 'string|required',
            'drop_address_detail' => 'string|nullable',
            'customer_name' => 'string|required',
            'phone_number' => 'string|required',
            'second_phone_number' => 'string|nullable',
            'payment_type' => 'string|required',
            'distance' => 'numeric|required',
            'total_price' => 'numeric|required',
            'delivery_price' => 'numeric|required',
        ]);
        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }


        try {
            DB::beginTransaction();
            $files = $request->allFiles();
            $orderNumber = $request->session()->get('orders_number');
            $orderTemp = OrderTemp::where('orders_number', $orderNumber)->first();

            $slip_image = "";
            if (isset($files['slip_image'][0])) {
                /* Upload Thumbnail */
                $newFolder = "upload/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
                $slip_image = $this->uploadImage($newFolder, $files['slip_image'][0], "", "", "");
            }

            $newOrder = new Order();
            $newOrder->orders_number = $orderTemp->orders_number;
            $newOrder->status_id = 2;
            $newOrder->delivery_drop = $request->drop_location;
            $newOrder->delivery_drop_address = $request->drop_address;
            $newOrder->delivery_drop_address_more = $request->drop_address_detail;
            $newOrder->customer_name = $request->customer_name;
            $newOrder->phone_number = $request->phone_number;
            $newOrder->second_phone_number = $request->second_phone_number;
            $newOrder->transaction_date = $orderTemp->transaction_date;
            $newOrder->delivery_price = (int)$request->delivery_price;
            $newOrder->distance = $request->distance;
            $newOrder->total_price = (int)$request->total_price;
            $newOrder->save();


            OrderPayment::insert([
                'type' => $request->payment_type,
                'orders_number' => $orderTemp->orders_number,
                'time_pay' => new DateTime(),
                'slip_image' => $slip_image,

            ]);

            $request->session()->forget('orders_number');
            OrderTemp::where('orders_number', $orderNumber)->delete();

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
                'description' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }
}
