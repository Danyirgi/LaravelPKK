<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function index()
    {
        $data["count"] = User::count();
        $user = array();

        foreach (User::all() as $p) {
            $item = [
                "id"                => $p->id,
                "username"          => $p->username,
                "fullname"          => $p->fullname,
                "email"    	        => $p->email,
                "alamat"    	    => $p->alamat,
                "kodepos"    	    => $p->kodepos,
                "created_at"        => $p->created_at,
                "updated_at"        => $p->updated_at
            ];

            array_push($user, $item);
        }
        $data["user"] = $user;
        $data["status"] = 1;
        return response($data);
    }

    public function getAll($limit = 10, $offset = 0){
        $data["count"] = User::count();
        $user = array();

        foreach (User::take($limit)->skip($offset)->get() as $p) {
            $item = [
                "id"                => $p->id,
                "username"         => $p->username,
                "fullname"          => $p->fullname,
                "email"    	        => $p->email,
                "alamat"    	    => $p->alamat,
                "kodepos"    	    => $p->kodepos,
                "created_at"        => $p->created_at,
                "updated_at"        => $p->updated_at
            ];
            array_push($user, $item);
        }
        $data["user"] = $user;
        $data["status"] = 1;
        return response($data);
    }

    public function login(Request $request)
    {
		$credentials = $request->only('email', 'password');

		try {
			if(!$token = JWTAuth::attempt($credentials)){
				return response()->json([
						'logged' 	=>  false,
						'message' 	=> 'Invalid email and password'
					]);
			}
		} catch(JWTException $e){
			return response()->json([
						'logged' 	=> false,
						'message' 	=> 'Generate Token Failed'
					]);
		}

		return response()->json([
					"logged"    => true,
                    "token"     => $token,
                    "message" 	=> 'Login berhasil'
		]);
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'username'      => 'required|string|max:255',
			'fullname'      => 'required|string|max:255',
			'alamat'        => 'required|string|max:255',
			'email'         => 'required|string|email|max:255|unique:user',
			'password'      => 'required|string|min:6|confirmed',
			'kodepos'       => 'required|integer',
		]);

		if($validator->fails()){
			return response()->json([
				'status'	=> 0,
				'message'	=> $validator->errors()
			]);
		}

		$user = new User();
		$user->username 	= $request->username;
		$user->fullname 	= $request->fullname;
		$user->alamat 	    = $request->alamat;
		$user->email 	    = $request->email;
		$user->password     = Hash::make($request->password);
		$user->kodepos 	    = $request->kodepos;
		$user->save();

		$token = JWTAuth::fromUser($user);

		return response()->json([
			'status'	=> '1',
            'message'	=> 'Selamat anda berhasil registrasi',
            'token'     => $token,
		], 201);
    }
    
    public function LoginCheck(){
		try {
			if(!$user = JWTAuth::parseToken()->authenticate()){
				return response()->json([
						'auth' 		=> false,
						'message'	=> 'Invalid token'
					]);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
			return response()->json([
						'auth' 		=> false,
						'message'	=> 'Token expired'
					], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
			return response()->json([
						'auth' 		=> false,
						'message'	=> 'Invalid token'
					], $e->getStatusCode());
		} catch (Tymon\JWTAuth\Exceptions\JWTException $e){
			return response()->json([
						'auth' 		=> false,
						'message'	=> 'Token absent'
					], $e->getStatusCode());
		}

		 return response()->json([
		 		"auth"      => true,
                "user"    	=> $user
		 ], 201);
	}
}
