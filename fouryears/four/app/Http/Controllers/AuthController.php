<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Applications;
use App\Models\Teachers;
// use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Controller;
// use Tymon\JWTAuth\Facades\JWTFactory;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     * 要求附带email和password（数据来源users表）
     * 
     * @return void
     */
    // public function __construct()
    // {
    //       // 这里额外注意了：官方文档样例中只除外了『login』
    //       // 这样的结果是，token 只能在有效期以内进行刷新，过期无法刷新
    //       // 如果把 refresh 也放进去，token 即使过期但仍在刷新期以内也可刷新
    //       // 不过刷新一次作废
    //     $this->middleware('auth:api', ['except' => ['login']]);
    //       // 另外关于上面的中间件，官方文档写的是『auth:api』
    //       // 但是我推荐用 『jwt.auth』，效果是一样的，但是有更加丰富的报错信息返回
    // }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
   

    public function login()
    {
        $username=Request::get('username');
        if(!$user=Applications::where('username',$username)->first()){
            return ['message'=>'用户不存在,请先注册','status'=>'-1',];
        }
        else
        {
           if(Request::get('password')==$user['password'])
            {
                $token = JWTAuth::fromUser($user);
                return $this->respondWithToken($token,$username);
            }
            else{
                return ['message'=>'密码错误','status'=>'-1'];//登录失败
            }
        }
    }
 
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function me()
    // {
         
    //     return Applications::all();
    //     // return response()->json(JWTAuth::user());
    // }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    // public function refresh()
    // {
    //     return $this->respondWithToken( JWTAuth::refresh());
    // }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$username)
    {
        return response()->json([
            'status'=>'1',
            'access_token' => $token,
            'token_type' => 'bearer',
            'message'=>'登录成功',
            'username'=>$username,
            'expires_in' =>  JWTAuth::factory()->getTTL() * 60
        ]);
    }
    public function tea_login(){
        $username=Request::get('username');
        $user=Teachers::where('username',$username)->first();
        if(Request::get('password')==$user['password'])
            {
                // $token = JWTAuth::fromUser($user);
                // return $this->respondWithToken($token);
                return ['message'=>'登陆成功','status'=>'1','username'=>$username];
            }
            else{
                return ['message'=>'密码错误','status'=>'-1'];//登录失败
            }
    }
    
}