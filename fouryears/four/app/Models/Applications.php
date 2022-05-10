<?php
namespace App\Models;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use App\Models\Enrolls;
use Illuminate\Support\Facades\DB;
class Applications extends Authenticatable implements JWTSubject
    {
        use Notifiable;
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
        protected $casts = [
            'created_at' => 'date:Y-m-d',
            'updated_at' => 'date:Y-m-d'
        ];
    public function view(){
        // $this->username='张一鸣';
        // $this->phone='13233894565';
        // $this->favorite_teacher='何渊淘';
        // $this->save();
        // $inf=Request::get('name');这样写没有问题
        return $this->all();
        // return 1;
    }
    //检查和注册合二为一
    
    // public function register(){


    //     return 111;
    // }
    public function register(){
        $username=Request::get("username");
        $password=Request::get("password");
        $repassword=Request::get("repassword");
        if($password!=$repassword){
            return ['message'=>'确认密码与初始密码不一致','status'=>'1'];
        }
        if($this->where('username',$username)->first()){
            return 0;

        }
        else{
            $this->username=Request::get("username");
            $this->password=Request::get("password");
            $this->phone=Request::get("phone");
            $this->save();
            DB::insert("insert into enrolls(username) values ('{$username}');");
            return 1;
        }
       
        
    }
    
}