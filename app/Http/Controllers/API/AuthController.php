<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Xử lý yêu cầu đăng nhập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkLogin(Request $request)
    {
        $email = $request->input('email');
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validator->fails()) {
            $msg = [];

            foreach(array_values($validator->errors()->toArray()) as $val) {
                foreach($val as $error) {
                    $msg[] = $error;
                }

            }

            $res = [
                'status' => 200,
                'success'=>false,
                'message' => $msg
            ];

            return response()->json($res);
        }
        $user  = User::where('email', $email)->get()->first();
        if($user) {
            $res = [
                'status' => 200,
                'success'=>true,
                'message' => "success",
                'data' => ['is_user'=>true,'is_first_login'=>$user->first_login,'res'=>$user]
            ];

            return response()->json($res); 
        }

        else {
            $res = [
                'status' => 200,
                'success'=>false,
                'message' => "User not found"
            ];

            return response()->json($res); 

        }
    }

    /**
     * Xử lý yêu cầu đăng nhập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function firstLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'repassword' => 'required',
        ]);

        if($validator->fails()) {
            $msg = [];

            foreach(array_values($validator->errors()->toArray()) as $val) {
                foreach($val as $error) {
                    $msg[] = $error;
                }

            }

            $res = [
                'response_index' => true,
                'response_type' => 'error',
                'response_data' => $msg,
                'authenticated' => false,
            ];

            return response()->json($res, 200);
        }
        $user  = User::where('email', $request->email)->get()->first();
        if(!$user || $user->first_login !=1) {
            $res = [
                'response_index' => true,
                'response_type' => 'error',
                'response_data' => ["Check first login false",$user->firstLogin],
                'authenticated' => false,
            ];

            return response()->json($res); 
        }
        $user->password = Hash::make($request->password);
        $user->first_login = 0;
        $user->save();
        if(Auth::attempt($request->only('email', 'password'))) {
            $res = [
                'response_index' => true,
                'response_type' => 'success',
                'response_data' => ['You Have Logged In Successfully'],
                'authenticated' => true,
            ];
            return response()->json($res, 200); 
        }

        else {
            $res = [
                'response_index' => true,
                'response_type' => 'error',
                'response_data' => ['Given Credentials Does Not Match Our Record'],
                'authenticated' => false,
            ];

            return response()->json($res, 200);
        }
    }

    /**
     * Xử lý yêu cầu đăng nhập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            $msg = [];

            foreach(array_values($validator->errors()->toArray()) as $val) {
                foreach($val as $error) {
                    $msg[] = $error;
                }

            }

            $res = [
                'response_index' => true,
                'response_type' => 'error',
                'response_data' => $msg,
                'authenticated' => false,
            ];

            return response()->json($res, 200);
        }

        if(Auth::attempt($request->only('email', 'password'))) {
            $res = [
                'response_index' => true,
                'response_type' => 'success',
                'response_data' => ['You Have Logged In Successfully'],
                'authenticated' => true,
            ];

            return response()->json($res, 200); 
        }

        else {
            $res = [
                'response_index' => true,
                'response_type' => 'error',
                'response_data' => ['Given Credentials Does Not Match Our Record'],
                'authenticated' => false,
            ];

            return response()->json($res, 200);
        }
    }
     /**
     * lây thông tin user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logged(Request $request)
    {
        
        $req = $request->user();
        $req['roles'] = $req->getRoleNames()->first();
        
        return response()->json($req, 200); 
    }

     /**
     * logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return response()->json('logout successfull');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
