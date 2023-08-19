<?php

use App\Http\Controllers\Tenant\TenantController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

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

// tenant group
// Route::group([
//     'prefix' => '/tenant',
//     'as' => 'tenant.',
//   ], function () {
//       Route::get('/login', [TenantController::class, 'login_view'])->name('login');
//       Route::post('/login' , [TeanantController::class , 'checkLoginCredential'])->name('login.store');

//       Route::get('/register', [TenantController::class, 'register_view'])->name('register');
//       Route::post('/register' , [TeanantController::class , 'store_tenant'])->name('register.store');
//       Route::post('/logout' , [TeanantController::class , 'logout'])->name('logout');
//      // Route::post('/logout', 'logout')->name('logout');

// });


// // user group
// Route::group([
//     'prefix' => '/user',
//     'as' => 'user.',
//   ], function () {
//       Route::get('/login', [UserController::class, 'login_view'])->name('login');
//       Route::post('/login' , [UserController::class , 'checkLoginCredential'])->name('login.store');

//       Route::get('/register', [UserController::class, 'register_view'])->name('register');
//       Route::post('/register' , [UserController::class , 'store_user'])->name('register.store');
//       Route::post('/logout' , [UserController::class , 'logout'])->name('logout');
//      // Route::post('/logout', 'logout')->name('logout');

// });
