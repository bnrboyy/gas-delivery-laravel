<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
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
            OrderItem::where(['orders_number' => $request->ordernumber, 'product_id' => $request->pid, 'quantity' => $request->quantity])->delete();

            DB::commit();
            return response([
                'message' => 'ok',
                'description' => 'Delete order item success.',
                'status' => true,
            ], 200);

        } catch(Exception $e) {
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
