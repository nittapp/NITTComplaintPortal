
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
Route::post('/v1/complaints','ComplaintController@createComplaints');
Route::put('/v1/complaints','ComplaintController@editComplaints');
Route::delete('/v1/complaints','ComplaintController@deleteComplaints');



Route::get('/v1/comments/{complaint_id}','ComplaintCommentController@getComments');
Route::post('/v1/comments','ComplaintCommentController@createComments');
Route::put('/v1/comments','ComplaintCommentController@editComments');
Route::delete('/v1/comments/{complaint_comment_id}','ComplaintCommentController@deleteComments');

Route::get('/v1/replies/complaint_comment_id','ComplaintReplyController@getReplies');
Route::post('/v1/replies','ComplaintReplyController@createReplies');
Route::put('/v1/replies','ComplaintReplyController@editReplies');
Route::delete('/v1/replies/complaint_reply_id','ComplaintReplyController@deleteReplies');

Route::get('/v1/admin/complaints','ComplaintController@getAllComplaints');

Route::put('/v1/complaints/{complaint_id}/status/{status_id}','ComplaintController@editComplaintStatus');
