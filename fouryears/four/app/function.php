<?php
namespace App;
use Illuminate\Support\Facades\Request;
function rq($key=null){
    if(!$key) return Request::all();
    else return Request::get($key);
};