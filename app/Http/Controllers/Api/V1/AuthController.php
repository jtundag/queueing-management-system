<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    /**
    * Create a new AuthController instance.
    *
    * @return void
    */
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register', 'me']]);
    }

    /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['user' => $user]);
    }

    /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function login(){
        $credentials = request(['username', 'password']);
        $token = auth('api')->attempt($credentials);
        if (!$token) return response()->json(['status' => false, 'error' => 'Invalid username or password.']);
        if($token && !$this->guard()->user()['verified_at'] && \Bouncer::is($this->guard()->user())->an('student')) return response()->json(['status' => false, 'error' => 'User not verified.', 'is_verified' => false]);
        return $this->respondWithToken($token);
    }

    /**
    * Get the authenticated User.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function me(){
        $status = true;
        $user = null;
        $message = 'Success!';
        
        try {
            $user = \JWTAuth::parseToken()->authenticate();
            $user['roles'] = $user->roles;
            $user['department'] = $user->department;
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            $status = false;
            $message = 'Expired token. Please try to re-login.';
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            $status = false;
            $message = 'Invalid token.';
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            $status = false;
            $message = 'Cannot find token.';
        }
        return response()->json([
            'status' => $status,
            'user' => $user,
            'access_token' => auth('api')->getToken()->get(),
            'message' => $message,
        ]);
    }

    /**
    * Log the user out (Invalidate the token).
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function logout(){
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
    * Refresh a token.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function refresh(){
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
    * Get the token array structure.
    *
    * @param string $token
    *
    * @return \Illuminate\Http\JsonResponse
    */
    protected function respondWithToken($token){
        $user = $this->guard()->user();
        $user['roles'] = $user->roles;
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function guard(){
        return \Auth::Guard('api');
    }
}
