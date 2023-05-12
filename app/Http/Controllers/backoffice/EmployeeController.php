<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function getEmployee(Request $req)
    {
        try {
            $employee = Employee::leftJoin('admin_statuses', 'employees.status', 'admin_statuses.id')
                ->select(['employees.*', 'admin_statuses.status_name'])->get();
            return response([
                'message' => 'ok',
                'description' => 'get employee success',
                'data' => $employee
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getEmployeeById(Request $req)
    {
        try {
            $employee = DB::table('employees')
                ->leftJoin('admin_statuses', 'employees.status', 'admin_statuses.id')
                ->select(['employees.*', 'admin_statuses.status_name'])
                ->where('employees.id', "=", $req->id)
                ->first();
            if (!$employee) {
                return response([
                    'message' => 'error',
                    'description' => 'employee was not found'
                ]);
            }
            return response([
                'message' => 'ok',
                'description' => 'get employee by id success',
                'data' => $employee
            ]);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function onDeleteEmployee(Request $req)
    {
        try {
            $member = Employee::where('id', $req->id)->first();
            if (!$member) {
                return response([
                    'message' => 'error',
                    'description' => 'employee was not found'
                ], 404);
            }
            $member->delete();
            return response([
                'message' => 'ok',
                'description' => 'delete employee success',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function onEditEmployee(Request $req)
    {
        $files = $req->allFiles();
        $validator = Validator::make($req->all(), [
            'address' => 'string',
            'district' => 'string',
            'firstname' => 'string',
            'gender' => 'string',
            'lastname' => 'string',
            'moo' => 'string',
            'phone_number' => 'string',
            'province' => 'string',
            'subdistrict' => 'string',
            'zipcode' => 'string',
            'imageFile' => 'mimes:jpeg,jpg,png,gif'
        ]);
        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }
        try {
            $employee = Employee::where('id', $req->id)->first();
            if (!$employee) {
                return response([
                    'message' => 'error',
                    'description' => 'Employee not found.'
                ]);
            }
            $image_link = "";
            if (isset($files['imageFile'])) {
                /* Upload Thumbnail */
                $newFolder = "upload/" . date('Y') . "/" . date('m') . "/" . date('d') . "/";
                $image_link = $this->uploadImage($newFolder, $files['imageFile'], "", "", "");
                $employee->profile_image = $image_link;
            }
            $employee->firstname = $req->firstname;
            $employee->lastname = $req->lastname;
            $employee->phone_number = $req->phone_number;
            $employee->address = $req->address;
            $employee->moo = $req->moo;
            $employee->subdistrict = $req->subdistrict;
            $employee->district = $req->district;
            $employee->province = $req->province;
            $employee->zipcode = $req->zipcode;
            $employee->status = $req->status;
            $employee->gender = $req->gender;
            $employee->save();

            return response([
                'message' => 'ok',
                'description' => 'edit employee success',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'description' => 'something went wrong.',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }
}
