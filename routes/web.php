<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerReponse;
use App\Http\Controllers\ControllerPortraitWeb;

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

Route::get("testReponseWithQuestion/{reponse}", [ControllerReponse::class, "reponseWithQuestion"]);

Route::resource('portrait', ControllerPortraitWeb::class);