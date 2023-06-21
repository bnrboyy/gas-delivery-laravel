<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\BankInfo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    public function createBank(Request $request)
    {

        DB::beginTransaction();
        $files = $request->allFiles();

        $validator = Validator::make($request->all(), [
            'bankName' => 'string|required',
            'bankId' => 'string|required',
            'accountName' => 'string|required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        try {

            /* Upload Image */
            $newFolder = "upload/" . date('Y') . "/" . date('m') . '/' . date('d') . "/";
            $imgSrc = (isset($files['image'])) ? $this->uploadImage($newFolder, $files['image'], "", "", "bank") : "";

            $newBank = new BankInfo();
            $newBank->bank_name = $request->bankName;
            $newBank->bank_account = $request->accountName;
            $newBank->bank_number = $request->bankId;
            $newBank->display = 1;
            $newBank->bank_image = $imgSrc;
            $newBank->save();

            DB::commit();
            return response([
                'data' => [
                    'requestAll' => $request->all(),
                    'file' => $request->allFiles(),
                    'message' => 'ok',
                    'description' => 'Create bank success.',
                    'status' => true,
                ],
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'data' => [
                    'message' => 'error',
                    'description' => 'Something went wrong!',
                    'errorMessage' => $e->getMessage(),
                    'status' => false,
                ],
            ], 500);
        }
    }

    public function getBankById(Request $request)
    {
        try {

            $bank = BankInfo::where(['id' => $request->id])->first();
            if (!$bank) {
                return response([
                    'data' => [
                        'message' => 'error',
                        'description' => 'Bank not found!',
                        'status' => false,
                    ],
                ], 404);
            }

            return response([
                'data' => [
                    'data' => $bank,
                    'message' => 'ok',
                    'description' => 'Get bank by id success.',
                    'status' => true,
                ],
            ], 200);
        } catch (Exception $e) {
            return response([
                'data' => [
                    'message' => 'error',
                    'description' => 'Something went wrong!',
                    'errorMessage' => $e->getMessage(),
                    'status' => false,
                ],
            ], 500);
        }
    }

    public function updateBank(Request $request)
    {
        try {
            DB::beginTransaction();
            /* Upload Image */
            $files = $request->allFiles();
            $newFolder = "upload/" . date('Y') . "/" . date('m') . '/' . date('d') . "/";
            $imgSrc = (isset($files['image'])) ? $this->uploadImage($newFolder, $files['image'], "", "", "bank") : "";

            $bank = BankInfo::findOrFail($request->id);
            if (!$bank) {
                return response([
                    'data' => [
                        'message' => "error",
                        'description' => 'Bank not found!',
                        'status' => false,
                    ],
                ], 404);
            }

            $bank->bank_name = $request->bankName;
            $bank->bank_account = $request->accountName;
            $bank->bank_number = $request->bankId;
            if (isset($files['image'])) {
                $bank->bank_image = $imgSrc;
            }
            $bank->save();

            DB::commit();
            return response([
                'data' => [
                    'message' => $request->all(),
                    'description' => 'Update bank success.',
                    'status' => true,
                ],
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'data' => [
                    'message' => 'error',
                    'description' => 'Something went wrong!',
                    'errorMessage' => $e->getMessage(),
                    'status' => false,
                ],
            ], 500);
        }
    }

    public function updateDisplayBank(Request $request)
    {
        try {
            DB::beginTransaction();
            $bank = BankInfo::findOrFail($request->id);
            if ($bank) {
                $bank->display = $request->checked === "true" ? 1 : 0;
                $bank->save();
            }

            DB::commit();
            return response([
                'data' => [
                    'display' => $request->checked,
                    'message' => $bank,
                    'description' => 'Update bank display success.',
                    'status' => true,
                ],
            ], 201);
        } catch (Exception $e) {
            DB::rollBank();
            return response([
                'data' => [
                    'message' => 'error',
                    'description' => 'Something went wrong!',
                    'errorMessage' => $e->getMessage(),
                    'status' => false,
                ],
            ], 500);
        }
    }

    public function deleteBank(Request $request)
    {
        try {
            $id = $request->id;
            BankInfo::where(['id' => $id])->first()->delete();

            return response([
                'data' => [
                    'message' => 'ok',
                    'description' => 'delete bank success.',
                    'status' => true,
                ],
            ], 200);
        } catch (Exception $e) {
            return response([
                'data' => [
                    'message' => 'error',
                    'description' => 'Something went wrong!',
                    'errorMessage' => $e->getMessage(),
                    'status' => false,
                ],
            ], 500);
        }
    }
}
