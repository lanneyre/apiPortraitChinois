<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerPortrait;
use App\Http\Controllers\ControllerQuestion;
use App\Http\Controllers\ControllerReponse;
use App\Http\Controllers\ControllerResultat;
use App\Http\Controllers\ControllerUser;




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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(["prefix" => "portrait"], function(){
//     Route::get("/", [ControllerPortrait::class, "index"])->name("portrait.index");
// });

//
// Route::resource("portrait", ControllerPortrait::class)->except(["create", "edit"]);
// Route::apiResource("portrait", ControllerPortrait::class);

Route::group(["prefix" => "question"], function(){
    //Route::get("/", [Question::class, "index"])->name("question.index");
    Route::post("/questionWithReponses", [ControllerQuestion::class, "questionWithReponses"])->name("question.questionWithReponses");
    Route::get("/questionToPortrait/{question}/{portrait}", [ControllerQuestion::class, "questionToPortrait"])->name("question.questionToPortrait");
    Route::delete("/delQuestionToPortrait/{question}/{portrait}", [ControllerQuestion::class, "delQuestionToPortrait"])->name("question.delQuestionToPortrait");
});

Route::apiResources([
    'portrait' => ControllerPortrait::class,
    'question' => ControllerQuestion::class,
    'reponse' => ControllerReponse::class,
    'resultat' => ControllerResultat::class,
    'user' => ControllerUser::class,
]);





// Route::group(["prefix" => "reponse"], function(){
//     Route::get("/", [Reponse::class, "index"])->name("reponse.index");
// });

// Route::group(["prefix" => "resultat"], function(){
//     Route::get("/", [Resultat::class, "index"])->name("resultat.index");
// });

// Route::group(["prefix" => "user"], function(){
//     Route::get("/", [User::class, "index"])->name("user.index");
// });