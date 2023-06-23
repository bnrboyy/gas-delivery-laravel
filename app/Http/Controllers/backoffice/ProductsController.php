<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\WebInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsController extends BaseController
{
    public function getProducts(Request $req)
    {
        try {
            $cateId = $req->input('cateId');
            $language = $req->input('language');
            if ($cateId) {
                $products = DB::select('SELECT * FROM (
                    SELECT * FROM products
                    WHERE (cate_id = :cateId AND language = :lang) /* OR (page_id = :cateIdd AND defaults = 1)*/
                    ORDER BY defaults ASC
                ) as product GROUP BY id ORDER BY updated_at DESC', [':cateId' => $cateId, ':lang' => $language]);
                return response([
                    'message' => 'ok',
                    'description' => 'get product success',
                    'data' => $products
                ], 200);
            } else {
                $products = DB::select('SELECT * FROM (
                    SELECT * FROM products
                    WHERE language = :lang OR defaults = 1
                    ORDER BY defaults ASC
                ) as product GROUP BY id ORDER BY updated_at DESC', [':lang' => $language]);
                return response([
                    'message' => 'ok',
                    'description' => 'get product success',
                    'data' => $products
                ], 200);
            }
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductById(Request $req)
    {
        try {
            $data = Product::where('id', $req->id)->first();
            if(!$data){
                return response([
                    'message' => 'error',
                    'description' => 'Product not found.'
                ], 404);
            }
            return response([
                'message' => 'ok',
                'description' => 'get product success',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function createProduct(Request $req)
    {
        $this->getAuthUser();

        $files = $req->allFiles();
        $params = $req->all();
        $validator = Validator::make($req->all(), [
            'image' => 'mimes:jpg,png,jpeg|max:5120|nullable',
            'imageName' => 'string|nullable',
            'imageTitle' => 'string|nullable',
            'imageAlt' => 'string|nullable',
            'title' => 'required|string',
            'price' => 'numeric|nullable',
            'details' => 'string|nullable',
            'description' => 'string|nullable',
            'display' => 'required|numeric',
            'cate_id' => 'numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {

            /*  Upload Image  */
            $newFolder = "upload/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
            $imgSrc = (isset($files['image'])) ? $this->uploadImage($newFolder, $files['image'], "", "", $params['imageName']) : "";

            $creating = new Product();
            $creating->thumbnail_link = $imgSrc;
            $creating->thumbnail_title = $params['imageTitle'];
            $creating->thumbnail_alt = $params['imageAlt'];
            $creating->title = $params['title'];
            $creating->details = $params['details'];
            $creating->description = $params['description'];
            $creating->display = $params['display'];
            $creating->price = $params['price'];
            $creating->language = "th";
            $creating->cate_id = $params['cate_id'];
            $creating->save();

            return response([
                'message' => 'success',
                'description' => 'Created successfully'
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProduct(Request $req)
    {
        $this->getAuthUser();

        $files = $req->allFiles();
        $params = $req->all();
        $validator = Validator::make($req->all(), [
            'id' => 'required|string',
            'image' => 'mimes:jpg,png,jpeg|max:5120|nullable',
            'imageName' => 'string|nullable',
            'imageTitle' => 'string|nullable',
            'imageAlt' => 'string|nullable',
            'title' => 'required|string',
            'price' => 'numeric|nullable',
            'details' => 'string|nullable',
            'display' => 'required|numeric',
            'cate_id' => 'numeric'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            DB::beginTransaction();

            $conditions = ['id' => $params['id'] ];
            $values = [
                'thumbnail_title' => $params['imageTitle'],
                'thumbnail_alt' => $params['imageAlt'],
                'title' => $params['title'],
                'price' => $params['price'],
                'details' => $params['details'],
                'display' => $params['display'],
                'language' => "th",
                'cate_id' => $params['cate_id'],
            ];

            if (isset($files['image'])) {
                /* Upload Image */
                $newFolder = "upload/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
                $values['thumbnail_link'] = $this->uploadImage($newFolder, $files['image'], "", "", $params['imageName']);
            } else {
                $values['thumbnail_link'] = $params['thumbnail_link'];
            }

            DB::table('products')->updateOrInsert($conditions, $values);
            DB::commit();
            return response([
                'message' => 'success',
                'description' => 'Updated Product successfully'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteProduct(Request $req)
    {
        $this->getAuthUser();
        try {
            Product::where(['id' => $req->id, 'language' => $req->language])->delete();
            return response([
                'message' => 'success',
                'description' => 'Deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getCapacity(Request $request)
    {
        $current = $this->getCurrentOrderWashItemAdmin($request->orders_number, $request->product_id, $request->page_id, $request->cart_number);
        if(count($current) == 0){
            return response([
                'message' => 'error',
                'description' => 'capacity not found.'
            ], 404);
        }
        $capacity = Product::where(['page_id' => $request->page_id, 'cate_id' => 3, 'language' => $current[0]->language])->get();
        $infos = $this->getWebInfo('', $current[0]->language);
        $webInfo = $this->infoSetting($infos);
        $current[0]->totalPrice += ($current[0]->round_minutes > 0)?($current[0]->minutes_add / $current[0]->round_minutes) * $current[0]->price_per_minutes:0;
        return response([
            'message' => 'ok',
            'description' => 'Get capacity success.',
            'data' => [
                'capacity' => $capacity,
                'current' => $current[0],
                'currency' => $webInfo->settings->currency_symbol->value
            ]
        ], 200);
    }

    /* Private function */
    private function priorityProductUpdate($column, $language, $newPriority)
    {
        $checkPr = Product::where($column, $newPriority)->where('language', $language)->get()->first();
        $maxPr = Product::orderBy('priority', 'DESC')->get()->first();
        if ($checkPr) {
            /* ถ้า Priority ซ้ำ */
            return Product::where($column, $newPriority)->update([$column => $maxPr->priority + 1]);
        } else {
            return false;
        }
    }
}
