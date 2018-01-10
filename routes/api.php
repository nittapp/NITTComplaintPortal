
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


Route::get('/v1/complaints','ComplaintController@getUserComplaints');
Route::delete('/v1/complaints','ComplaintController@deleteComplaints');
Route::post('/v1/complaints','ComplaintController@createComplaints');

Route::get('/v1/comments','ComplaintCommentController@getComments');
Route::post('/v1/comments','ComplaintCommentController@createComments');
Route::put('/v1/comments','ComplaintCommentController@editComments');

Route::get('/v1/admin/complaints','ComplaintController@getAllComplaints');
