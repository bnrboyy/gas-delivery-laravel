<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Mail\frontend\SendMailResetPasswordFrontend;
use App\Models\MemberAccount;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends BaseController
{
    public function getMember(Request $req)
    {
        try {
            $search = $req->search != "null" ? $req->search : "";
            $data = MemberAccount::where('member_name', 'like', '%' . $search . '%')->get();
            if (!$data) {
                $data = MemberAccount::all();
            }
            $newData = array();

            foreach ($data as $key => $value) {
                $arr = array();
                $arr['id'] = $value->id;
                $arr['firstname'] = $value->firstname;
                $arr['lastname'] = $value->lastname;
                $arr['member_name'] = $value->member_name;
                $arr['profile_image'] = $value->profile_image;
                $arr['facebook_id'] = $value->facebook_id;
                $arr['google_id'] = $value->google_id;
                $arr['line_id'] = $value->line_id;
                $arr['apple_id'] = $value->apple_id;
                $arr['member_status'] = $value->member_status;
                $arr['member_note'] = $value->member_note;
                $arr['member_verify_at'] = $value->created_at;

                array_push($newData, $arr);
            }

            return response([
                'message' => 'ok',
                'description' => 'get member success',
                'data' => $newData
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function getMemberById(Request $req)
    {
        try {
            $member = MemberAccount::where('id', $req->id)->first();
            if (!$member) {
                return response([
                    'message' => 'error',
                    'description' => 'member was not found'
                ]);
            }
            return response([
                'message' => 'ok',
                'description' => 'get member by id success',
                'data' => $member
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function onDeleteMember(Request $req)
    {
        try {
            $member = MemberAccount::where('id', $req->id)->first();
            if (!$member) {
                return response([
                    'message' => 'error',
                    'description' => 'member was not found'
                ], 404);
            }
            $member->delete();
            return response([
                'message' => 'ok',
                'description' => 'delete member success',
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function onChangeStatusMember(Request $req)
    {
        try {
            $member = MemberAccount::where('id', $req->id)->first();
            if (!$member) {
                return response([
                    'message' => 'error',
                    'description' => 'member was not found.'
                ], 404);
            }
            $member->member_status = $req->status;
            $member->save();
            return response([
                'message' => 'ok',
                'description' => 'change status success.'
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function memberRegister(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email:rfc|unique:member_accounts',
            'lineId' => 'string|nullable',
            'phone' => 'required|numeric',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators("Invalid params", $validator->errors());
        }

        $params = $req->all();
        try {
            DB::beginTransaction();
            $memberCreated = MemberAccount::create([
                'member_name' => $params['name'],
                'password' => Hash::make($params['password']),
                'email' => strtolower($params['email']),
                'line_id' => $params['lineId'],
                'phone_number' => $params['phone'],
                'member_status' => 'pending',
            ], Response::HTTP_CREATED);

            DB::commit();
            return response([
                'message' => 'success',
                'status' => true,
                'description' => 'An account has been created successfully.',
                'confirm_token' => $memberCreated
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 500);
        }
    }

    public function memberLogin(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        if (Auth::guard('member')->attempt(['email' => $req->username, 'password' => $req->password])) {
            $user = Auth::guard('member')->user();

            // $accessToken = $user->createToken('MemberAuthToken')->accessToken;
            return response([
                'message' => 'success',
                'status' => true,
                'description' => 'Sign-In Successfully!',
                'user_name' => $user,
            ], 200);
        } else {
            return response([
                'message' => 'error',
                'status' => false,
                'description' => 'Authorization failed!'
            ], 401);
        }
    }

    public function onLogout(Request $request)
    {
        try {
            Auth::guard('member')->logout();
            return response([
                'message' => 'ok',
                'description' => 'You have successfully logged out.',
                'status' => true,
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'description' => 'Logging out failed!',
                'errorMessage' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    public function onSubmitForgetPassword(Request $req)
    {

        $user = MemberAccount::where('email', $req->email)->get()->first();
        if (!$user) {
            return response([
                'message' => 'error',
                'description' => 'User not found'
            ], 400);
        }
        $token = md5($user->phone_number . $user->email . $user->id);
        DB::table('password_resets')->insert([
            'email' => $req->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        $reset_token = DB::table('password_resets')->orderBy('created_at', 'DESC')->get()->first();

        $result = $this->sendMailReset($user, $reset_token);
        return $result;
    }


    public function onResetPassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendErrorValidators('Invalid params', $validator->errors());
        }

        $params = $req->all();
        try {
            DB::beginTransaction();
            $reset_token = DB::table('password_resets')->where(['token' => $params['token']])->first();
            if (!$reset_token) {
                return response([
                    'message' => 'error',
                    'description' => 'Token has been revoked!'
                ], 400);
            }

            $userMember = MemberAccount::where(['email' => $reset_token->email])->first();
            if (!$userMember) {
                return response([
                    'message' => 'error',
                    'description' => 'User not found'
                ], 404);
            }

            // $memberAccount = MemberAccount::where('account_id', $userMember->id)->first();

            $userMember->password = Hash::make($params['password']);
            $userMember->save();
            DB::table('password_resets')->where(['token' => $params['token']])->delete();
            DB::commit();

            return response([
                'message' => 'success',
                'description' => 'Your password has been changed!'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'message' => 'error',
                'description' => 'Somethink went wrong',
                'errorMessage' => $e->getMessage()
            ], 501);
        }
    }

    public function changeLanguage(Request $request)
    {
        $cookie = cookie('language', $request->lang);
        return response([
            'message' => 'ok'
        ], 200)->cookie($cookie);
    }

    /* private function */
    private function sendMailReset($user, $reset_token)
    {

        try {
            // $infos = $this->getWebInfo('',);
            // $webInfo = $this->infoSetting($infos);

            Mail::to($user->email)->send(new SendMailResetPasswordFrontend($user, $reset_token));
            return response([
                'message' => 'ok',
                'description' => 'We have e-mailed your password reset link!'
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'error',
                'errorMessage' => $e->getMessage()
            ], 501);
        }
    }
}
