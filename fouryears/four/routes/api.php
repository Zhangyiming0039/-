<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AuthController;
use GuzzleHttp\Middleware;

/*
|
zzz--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::any('/register', [UserController::class, 'register']);
Route::group([

    'prefix' => 'auth'

], function ($router) {
    
    Route::any('logout', [AuthController::class, 'logout']);
    Route::any('refresh', [AuthController::class, 'refresh']);
    Route::any('me', [AuthController::class, 'me']);
  
});
// Route::get('register', [AuthController::class, 'register']);
Route::any('login', [AuthController::class, 'login']);
Route::any('tea_login', [AuthController::class, 'tea_login']);
Route::any('stu_info/favo_tea={favo_tea}', function ($favo_tea) {
    $app=new App\Models\Students;
    return $app->stu_info($favo_tea);
});
Route::any('register', function () {
    $app=new App\Models\Applications();
    return $app->register();
});
Route::any('enroll', function () {
    $app=new App\Models\Students();
    return $app->enroll();
});
Route::any('stu_delete/id={id}/username={username}/is_chosen={is_chosen}', function ($id,$username,$is_chosen) {
    $app=new App\Models\Students;
    return $app->stu_delete($id,$username,$is_chosen);
});
//下面的这条路由是显示学生已经保存的报名信息
Route::any('pre_enroll_info/username={username}', function ($username) {
    $app=new App\Models\Enrolls;
    return $app->pre_enroll_info($username);
});
//下面这条路由是学生点击保存报名信息后把信息保存到students里面
Route::any('pre_enroll/username={username}', function ($username) {
    $app=new App\Models\Enrolls;
    return $app->pre_enroll($username);
});
//这条路由是把学生的is_chosen状态改为1
Route::any('is_chosen/id={id}',function($id){
    $app=new App\Models\Students;
    return $app->is_chosen($id);
});
// ->middleware('jwt.auth')
Route::any('favo_stu_list/favo_tea={favo_tea}', function ($favo_tea) {
    $app=new App\Models\Students;
    return $app->favo_stu_list($favo_tea);
});
Route::any('favo_stu_list_delete/id={id}', function ($id) {
    $app=new App\Models\Students;
    return $app->favo_stu_list_delete($id);
});
Route::any('sub_stu_list/username={username}', function ($username) {
    $app=new App\Models\Students;
    return $app->sub_stu_list($username);
});
