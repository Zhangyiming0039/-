<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

function rq($key=null){
    if(!$key) return Request::all();
    else return Request::get($key);
};
class Enrolls extends Model{
    use HasFactory;
  
    public function enroll(){
        $this->student_id=rq("student_id");
        $this->name=rq("name");
        $this->phone=rq('phone');
        $this->email=rq('email');
        $this->favorite_teacher=rq("favorite_teacher");
        $this->personal_desc=rq('value');
        // if($this->save()){
        //     return ['message'=>'提交成功'];
        // }
        // else{
        //     return ['message'=>'提交失败,请稍后再试'];
        // };
        $this->save();
       ;
    }
}