<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductCategoriesController extends BaseController
{
    //

    public function getProductCategories(Request $req)
    {
        try {
            $product_cate = DB::select('SELECT * FROM (
                SELECT * FROM product_categories
                WHERE language = :lang OR defaults = 1
                ORDER BY defaults ASC
            ) as product_category GROUP BY id ORDER BY updated_at DESC', [':lang' => $req->language]);
            return response([
                'message' => 'ok',
                'description' => 'get product catgories success',
                'data' => $product_cate
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductCategoryById(Request $req)
    {
        try {
            $data = ProductCategory::where(['id' => $req->id])->first();
            return response([
                'message' => 'ok',
                'description' => 'get product category success',
                'data' => $data,
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => "error",
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function createProductCate(Request $req)
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
            'details' => 'string|nullable',
            'display' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            $newFolder = "upload/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
            $imgSrc = (isset($files['image'])) ? $this->uploadImage($newFolder, $files['image'], "", "", $params['imageName']) : "";

            $creating = new ProductCategory();
            $creating->title = $params['title'];
            $creating->details = $params['details'];
            $creating->thumbnail_link = $imgSrc;
            $creating->thumbnail_title = $params['imageTitle'];
            $creating->thumbnail_alt = $params['imageAlt'];
            $creating->display = $params['display'];
            $creating->language = 'th';
            $creating->defaults = 1;
            $creating->save();

            return response([
                'message' => 'ok',
                'description' => 'created product category success'
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProductCate(Request $req)
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
            'details' => 'string|nullable',
            'display' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {
            DB::beginTransaction();
            $conditions = ['id' => $params['id'], 'language' => $params['language']];
            $values = [
                'thumbnail_title' => $params['imageTitle'],
                'thumbnail_alt' => $params['imageAlt'],
                'title' => $params['title'],
                'details' => $params['details'],
                'display' => $params['display'],
                'language' => "th",
            ];

            if (isset($files['image'])) {
                $newFolder = "upload/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
                $values['thumbnail_link'] = $this->uploadImage($newFolder, $files['image'], "", "", $params['imageName']);
            } else {
                $values['thumbnail_link'] = $params['thumbnail_link'];
            }

            DB::table('product_categories')->updateOrInsert($conditions, $values);
            DB::commit();
            return response([
                'message' => 'success',
                'description' => 'Updated Product category successfully'
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 501);
        }
    }

    public function deleteProductcate(Request $req)
    {
        $this->getAuthUser();
        try {
            ProductCategory::where(['id' => $req->id, 'language' => $req->language])->delete();
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
}
