<?php

use Illuminate\Http\Request;

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
Route::post('patient/login', 'PatientController@login');
Route::post('patient/register', 'PatientController@register');

Route::post('login', 'NutritionnistController@login');
Route::post('register', 'NutritionnistController@register');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return "i 'am nutritionnits";
});

Route::middleware('auth:api-patient')->get('patient/user', function (Request $request) {
    return "i 'am patient";
});
