<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HomeController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// For creting the roles using spatie package
Route::get('/create-role', function () {

    $roleList = Permission::create(['name' => 'role-list']);
    $roleCreate = Permission::create(['name' => 'role-create']);
    $roleEdit = Permission::create(['name' => 'role-edit']);
    $roleDelete = Permission::create(['name' => 'role-delete']);

    $role = Role::create(['name' => 'admin']);
    $role->givePermissionTo($roleList);
    $role->givePermissionTo($roleCreate);
    $role->givePermissionTo($roleEdit);
    $role->givePermissionTo($roleDelete);

    Auth::user()->givePermissionTo($roleList);
    Auth::user()->givePermissionTo($roleCreate);
    Auth::user()->givePermissionTo($roleEdit);
    Auth::user()->givePermissionTo($roleDelete);

    return 'Admin Role is created.';

});

// Routes for roles users and products using resourece
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});