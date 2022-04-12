<?php

use App\Application;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use  App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (){
    return "11";
});
// 返回用户信息
Route::any('/view', function () {
    $app=new App\Models\Applications;
    return $app->view();
});
Route::any('/user_check', function () {
    $app=new App\Models\Applications;
    return $app->check();
});
// 注册
// Route::any('/register', function () {
//     $app=new App\Models\Applications;
//     return $app->register();
// });

//登录
// Route::any('/login', function () {
//     $app=new App\Models\Applications;
//     return $app->login();
// })->name('login');
//返回学生报名信息
// Route::any('/stu_info', function () {
//     $app=new App\Models\Students;
//     return $app->stu_info();
// });
//提交报名表
Route::any('/enroll', function () {
    $app=new App\Models\Students;
    return $app->enroll();
});
// 登录
// Route::any('/login', [UserController::class, 'login']);
//修改报名信息
Route::any('/stu_patch/id={id}', function ($id) {
    $app=new App\Models\Students;
    return $app->stu_patch($id);
});
//返回个人详细信息
Route::any('/personal_info/id={id}', function ($id) {
    $app=new App\Models\Students;
    return $app->personal_info($id);
});
// Route::any('/stu_delete/id={id}', function ($id) {
//     $app=new App\Models\Students;
//     return $app->stu_delete($id);
// });
Route::any('/tea_login', function () {
    $app=new App\Models\Teachers();
    return $app->tea_login();
});
// 注册
// Route::any('/register', [UserController::class, 'register']);
// 
// Route::any('/enroll', [UserController::class, 'enroll']);
Route::any('/teacher_info', function () {
    $app=new App\Models\Teacher_info();
    return $app->write();
});//name是给这个路由起个别名
// Route::get('/login', [AuthController::class, 'login']);
// Route::get('/register', [AuthController::class, 'register']);
// Route::get('/me', [AuthController::class, 'me']);