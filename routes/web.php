<?php

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
Route::get('/images/{dir}/{filename}', function ($dir, $filename)
{   
    $path = storage_path().'/app/'.$dir.'/'.$filename;
    // return $path;
    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::any('{all}', function () {
    return view('app');
})
->where(['all' => '.*']);

