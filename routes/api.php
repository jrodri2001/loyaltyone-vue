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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('submission', 'SubmissionController@index');

Route::get('submissions', 'SubmissionController@view');

Route::post('submission/reply/{id}', 'SubmissionController@reply');

Route::get('latlong/{city}', 'SubmissionController@latlong');

Route::get('weather/{city}', 'SubmissionController@weather');