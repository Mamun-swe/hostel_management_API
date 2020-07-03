<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $method = $request->method();

        $valid = false;
        if($request->bearerToken()){
            $tokenExplode = explode(".", $request->bearerToken());
            $accountType = $tokenExplode[0];
            $token = $tokenExplode[1];
            $user = User::where('api_token', '=', $token)->first();
            if($user && $user->type == $accountType && $accountType == 'super_admin'){
                if($method == 'GET' | $method == 'POST'){
                    $valid = true;
                }else{
                    $valid = false;
                }
            }else{
                $valid = false;
            }
        }else{
            $valid = false;
        }
        
        if($valid == true){
            return $next($request);
        }else{
            return response()->json(['message' => 'You have no permission.'], 401);
        }
    }
}
