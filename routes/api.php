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

Route::middleware(['auth.student'])->group(function(){    
    Route::get('/v1/complaints','ComplaintController@getUserComplaints');
    Route::get('/v1/complaints/public','ComplaintController@getPublicComplaints');
    Route::post('/v1/complaints','ComplaintController@createComplaints');
    Route::post('/v1/complaints/edit','ComplaintController@editComplaints');
    Route::delete('/v1/complaints/{complaint_id}','ComplaintController@deleteComplaints');
    Route::get('/v1/comments/{complaint_id}','ComplaintCommentController@getComments');
    Route::post('/v1/comments','ComplaintCommentController@createComments');
    Route::put('/v1/comments','ComplaintCommentController@editComments');
    Route::delete('/v1/comments/{complaint_comment_id}','ComplaintCommentController@deleteComments');
});

Route::middleware(['auth.admin'])->group(function(){
    Route::get('/v1/admin/complaints','ComplaintController@getAllComplaints');
    Route::get('/v1/admin/statuses','ComplaintStatusController@getComplaintStatuses');
    Route::put('/v1/admin/complaints/{complaintID}/status/{statusID}','ComplaintController@editComplaintStatus');
    Route::put('/v1/admin/complaints/{complaintID}/public','ComplaintController@editIsPublicStatus');
});

