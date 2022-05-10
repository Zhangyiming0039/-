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
    use HasFactory;
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
    
    public function enroll(){
        $id=rq("student_id");
        $user=$this->where('student_id',$id)->first();
        if($user) return ['message'=>'切勿重复提交'];
        $this->student_id=rq("student_id");
        $this->name=rq("name");
        $this->phone=rq('phone');
        $this->email=rq('email');
        $this->favorite_teacher=rq("favorite_teacher");
        $this->personal_desc=rq('value');
        $this->username=rq('username');
        if($this->save()){
            return ['message'=>'提交成功'];
        }
        else{
            return ['message'=>'提交失败,请稍后再试'];
        };
        $this->save();
       ;
    }
    public function stu_info($favo_tea){
        // $users = DB::select("select * from students where favorite_teacher='+$favo_tea+'");
        $users = DB::select("select * from students where favorite_teacher='{$favo_tea}'");
        // return $this->where('favorite_teacher',$favo_tea)->all();
        return $users;
        
    }
    //返回意向学生名单
    public  function favo_stu_list($favo_tea){
            $users=DB::select("select * from students where favorite_teacher='{$favo_tea}'and is_chosen='1'");
            return $users;
    }
    //从意向学生名单里面删除学生
    public  function favo_stu_list_delete($id){
        $user=$this->where('id',$id)->first();
        $user->is_chosen='0';
        $user->save();
        return ['message'=>'移除成功'];
}
    //返回个人报名的详细信息
    public function personal_info($id){
        return $this->where('id',$id)->first();
    }
    public function stu_patch($id){
        $input=Request::all();
        dd($input);
    }
    //删除个人报名信息
    public function stu_delete($id,$username,$is_chosen){
        //在students表中把报名信息删掉
   
        // $user=$this->where('id',$id)->first();
        // $this->where('id',$id)->delete();
        DB::delete("delete from students where username='{$username}';");
        // if($is_chosen==1){
        //     return ['message'=>'已被双向选择，撤回失败'];
        // }
        $euser=DB::select("select * from enrolls where username='{$username}';");
        // return $euser;
        if($euser){
            DB::delete("delete from enrolls where username='{$username}';");
           
        };
        // DB::update("update enrolls set student_id='{$user->student_id}',name='{$user->name}',email='{$user->email}',phone='{$user->phone}',favorite_teacher='{$user->favorite_teacher}',personal_desc='{$user->personal_desc}' where username='{$username}';");
         return['message'=>'撤回成功'];      
    }
   
    
    //这个方法是把学生的is_chosen改成1
    public function is_chosen($id){
        // return "zz";
        $user=$this->where('student_id',$id)->first();
        if($user->is_chosen=="1"){
            return ['message'=>'您已经添加过了'];
        }
        else{
            $user->is_chosen="1";
            $user->save();
            return ['message'=>'加入成功'];
        }
    }
    public function sub_stu_list($username){
        $user = DB::select("select * from students where username='{$username}'");
        return $user;
    }
}
