<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//public route

Route::post('/auth/login',['uses'=>'Auth\AuthController@login','desc'=>'Login'])->name('auth.login');
Route::post('/auth/register',['uses'=>'Auth\AuthController@register','desc'=>'Register'])->name('auth.register');
Route::get('storage/dir',['uses'=>'StorageController@listDir','desc'=>'List dir'])->name('storage.dir.list');
Route::get('storage/file',['uses'=>'StorageController@listFile','desc'=>'List file'])->name('storage.file.list');

//protected route

Route::middleware(['auth:api'])->group(function () {

    Route::prefix('auth')->group(function (){
        Route::post('logout',['uses'=>'Auth\AuthController@logout','desc'=>'Logout'])->name('lauth.ogout');
        Route::post('refresh',['uses'=>'Auth\AuthController@refresh','desc'=>'Refresh token'])->name('token.refresh');
    });

    Route::get('me',['uses'=>'Acl\UserController@me','desc'=>'View self'])->name('self.view')->middleware('can:self.view');

    // Access control
    Route::prefix('acl')->group(function (){
        //User
        Route::get('user',['uses'=>'Acl\UserController@index','desc'=>'List user'])->name('user.list')->middleware('can:user.list');
        Route::post('user',['uses'=>'Acl\UserController@store','desc'=>'Create user'])->name('user.create')->middleware('can:user.create');
        Route::get('user/{id}',['uses'=>'Acl\UserController@show','desc'=>'View user detail'])->where('id', '[0-9]+')->name('user.view')->middleware('can:user.view');
        Route::put('user/{id}',['uses'=>'Acl\UserController@update','desc'=>'Update user'])->where('id', '[0-9]+')->name('user.edit')->middleware('can:user.edit');
        Route::delete('user/{id}',['uses'=>'Acl\UserController@destroy','desc'=>'Delete User'])->where('id', '[0-9]+')->name('user.delete')->middleware('can:user.delete');
        //Role
        Route::get('role',['uses'=>'Acl\RoleController@index','desc'=>'List role'])->name('role.list')->middleware('can:role.list');
        Route::post('role',['uses'=>'Acl\RoleController@store','desc'=>'Create role'])->name('role.create')->middleware('can:role.create');
        Route::get('role/{id}',['uses'=>'Acl\RoleController@show','desc'=>'View role detail'])->where('id', '[0-9]+')->name('role.view')->middleware('can:role.view');
        Route::put('role/{id}',['uses'=>'Acl\RoleController@update','desc'=>'Update role'])->where('id', '[0-9]+')->name('role.edit')->middleware('can:role.edit');
        Route::delete('role/{id}',['uses'=>'Acl\RoleController@destroy','desc'=>'Delete role'])->where('id', '[0-9]+')->name('role.delete')->middleware('can:role.delete');

        //Permission
        Route::get('permission',['uses'=>'Acl\PermissionController@index','desc'=>'List permission'])->name('permission.list')->middleware('can:permission.list');
        Route::post('permission',['uses'=>'Acl\PermissionController@store','desc'=>'Create permission'])->name('permission.create')->middleware('can:permission.create');
        Route::get('permission/{id}',['uses'=>'Acl\PermissionController@show','desc'=>'View permission detail'])->where('id', '[0-9]+')->name('permission.view')->middleware('can:permission.view');
        Route::put('permission/{id}',['uses'=>'Acl\PermissionController@update','desc'=>'Update permission'])->where('id', '[0-9]+')->name('permission.edit')->middleware('can:permission.edit');
        Route::delete('permission/{id}',['uses'=>'Acl\PermissionController@destroy','desc'=>'Delete permission'])->where('id', '[0-9]+')->name('permission.delete')->middleware('can:permission.delete');
    });
});

