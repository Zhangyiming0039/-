<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Applications;
class UserController extends Controller
{  
    //用户注册
    public function register()
    {
        
        $data=Request::get('username');
        
        dd($data);
       
    }
    //学生报名
    //验证用户登录
    public  function login(){
        
    }
}
