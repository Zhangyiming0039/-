<?php

namespace App\Models;

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

function rq($key=null){
    if(!$key) return Request::all();
    else return Request::get($key);
};
class Enrolls extends Model{
    use Notifiable;
    use HasFactory;
    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function pre_enroll_info($username){
        return $this->where('username',$username)->first();
    }
   //保存学生需要保存的报名信息
    public function pre_enroll($username){
        // 如果保存表里面有学生信息，就按照下面的操作；
        $mystudent_id=rq("student_id");
        $myname=rq("name");
        $myphone=rq('phone');
        $myemail=rq('email');
        $myfavorite_teacher=rq("favorite_teacher");
        $myvalue=rq('value');
        $user=$this->where('username',$username)->first();
        if($user){$user->student_id=$mystudent_id;
            $user->name=$myname;
            $user->phone=$myphone;
            $user->email=$myemail;
            $user->favorite_teacher=$myfavorite_teacher;
            $user->personal_desc=$myvalue;
            $user->save();
            return ['message'=>'保存成功'];
        }else{
            DB::insert("insert into enrolls(student_id,name,phone,email,favorite_teacher,personal_desc,username) values('{$mystudent_id}','{$myname}','{$myemail}','{$myphone}','{$myfavorite_teacher}','{$myvalue}','{$username}');");
            return ['message'=>'保存成功'];
        }
      
    }
}