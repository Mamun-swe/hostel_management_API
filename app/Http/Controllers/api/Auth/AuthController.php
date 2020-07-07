<?php

namespace App\Http\Controllers\api\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $apiToken;
    public function __construct(){
        $this->apiToken = uniqid(base64_encode(str_random(60)));
    }


    // Login
    public function Login(Request $request){
        $rules = [
            'email'=>'required|email',
            'password'=>'required|min:8'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
            'message' => $validator->messages(),
            ]);
        } else {
       
            $user = User::where('email',$request->email)->first();
            if($user) {
            
                if( password_verify($request->password, $user->password) ) {
                    // Update Token
                    $postArray = ['api_token' => $this->apiToken];
                    $login = User::where('email',$request->email)->update($postArray);
                    
                    if($login) {
                        return response()->json([
                            'id'           => $user->id,
                            'access_token' => $user->type.'.'.$this->apiToken,
                        ]);
                    }
                } else {
                    return response()->json([
                        'message' => 'invalid',
                    ], 204);
                }

            } else {
                return response()->json([
                    'message' => 'invalid',
                ], 204);
            }
        }
    }


    // Register
    public function Register(Request $request){
        // return response()->json('Register method ');
        $rules = [
            'building_id' => 'required',
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'type' => 'required|string',
            'phone' => 'required|string|max:255|unique:users|regex:/(01)[0-9]{9}/',
            'nid_birth' => 'required|string',
            'image' => 'string',
            'password' => 'required|string|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            $form_data = array(
                'building_id' => $request->building_id,
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'phone' => $request->phone,
                'nid_birth' => $request->nid_birth,
                'password' => bcrypt($request->password),
                'api_token' => $this->apiToken
            );
        
            $user = User::create($form_data);

            if($user) {
                return response()->json([
                    'id'           => $user->id,
                    'access_token' => $user->type.'.'.$this->apiToken,
                ], 200);
            } else {
                return response()->json([
                  'message' => 'Registration failed, please try again.',
                ], 204);
            }
            
        }
    }


    // Reset password
    public function Reset(Request $request){
        return response()->json('Reset method ');
    }


    // Me
    public function Me(Request $request){
        $tokenExplode = explode(".", $request->bearerToken());
        $token = $tokenExplode[1];
        $user = User::where('api_token', '=', $token)->first();
            if($user) {
                return response()->json($user);
            } else {
                return response()->json([
                    'message' => 'User not found',
                ], 204);
            }
    }


    // Logout
    public function Logout(Request $request){
        $tokenExplode = explode(".", $request->bearerToken());
        $token = $tokenExplode[1];
        $user = User::where('api_token', '=', $token)->first();
            if($user) {
                $postArray = ['api_token' => null];
                $logout = User::where('id',$user->id)->update($postArray);
                    if($logout) {
                        return response()->json([
                            'message' => 'success',
                        ], 200);
                    }
            } else {
                return response()->json([
                    'message' => 'User not found',
                ], 204);
            }
    }
}
