<?php

use App\Http\Controllers\SocialLoginController;
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

Route::get('login/{socialNetwork}', [SocialLoginController::class,'redirectToSocialNetwork'])->name('login.social')->middleware('guest');
Route::get('login/{socialNetwork}/callback', [SocialLoginController::class,'handleSocialNetworkCallback'])->middleware('guest');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
