<?php
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
class Students extends Authenticatable implements JWTSubject
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
    use HasFactory;
  
    public function stu_info($favo_tea){
        // $users = DB::select("select * from students where favorite_teacher='+$favo_tea+'");
        $users = DB::select("select * from students where favorite_teacher='{$favo_tea}'");
        // return $this->where('favorite_teacher',$favo_tea)->all();
        return $users;
        
    }
    public function pre_enroll(){
        $user=Students::where('username',rq("username"))->first();
        $user->student_id=rq("student_id");
        $user->name=rq("name");
        $user->phone=rq('phone');
        $user->email=rq('email');
        $user->favorite_teacher=rq("favorite_teacher");
        $user->personal_desc=rq('value');
        // $this->save();
        if($user->save()){
            return ['message'=>'保存成功'];
        }
        else{
            return ['message'=>'保存失败,请稍后再试'];
        };
    }
    //返回个人报名的详细信息
    public function personal_info($id){
        return $this->where('id',$id)->first();
    }
    public function stu_patch($id){
        // $input=Request::get('student_id');
        $input=Request::all();
        dd($input);
        // $info=$this->where('id',$id)->first();
        // $info['']
    }
    //删除个人报名信息
    public function stu_delete($id){
        return $this->where('id',$id)->delete();
        if($this->save()){
            dd('success');
        };
    }
    //下面这个方法是返回学生已保存的报名信息
    public function pre_enroll_info($username){
        return $this->where('username',$username)->first();
    }
}
