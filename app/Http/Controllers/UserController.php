<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Exception;
use App\Exceptions\AppCustomHttpException;

class UserController extends Controller{

    public function createUser(Request $request){

        try {
            $response = User::validateRequest($request);
            $response = User::createUser($request['username'],$request['name'],
                $request['room_no'],$request['hostel_id'],$request['phone_contact'],
                $request['whatsapp_contact'],$request['email'],$request['fcm_id']);

            return response()->json([
                                    "message" => "user created",
                                    ],200);
        }

        catch (AppCustomHttpException $e) {
            return response()->json([
                                    "message" => $e->getMessage(),
                                    ],$e->getCode());

        }

        catch (Exception $e) {
            return response()->json([
                                    "message" =>$e->getMessage(),
                                    ],500);
        }


    }

    public function getUser(Request $request){
        try {
            $response = User::getUser($request['user_id']); 

             return response()->json([
                                    "message" => "user details available",
                                    "data" => $response
                                    ],200);
        }

        catch (AppCustomHttpException $e) {

             return response()->json([
                                    "message" => $e->getMessage(),
                                    ],$e->getCode());

        }

        catch (Exception $e) {

            return response()->json([
                                    "message" =>$e->getMessage(),
                                    ],500);
        }
    }


     public function editUser(Request $request){
        try {
            $response = User::editUser($request['user_id'],$request['name'],$request['room_no'],
                $request['hostel_id'],$request['phone_contact'],$request['whatsapp_contact'],$request['email']); 

             return response()->json([
                                    "message" => "user detail edited",
                                    ],200);
        }

        catch (AppCustomHttpException $e) {

             return response()->json([
                                    "message" => $e->getMessage(),
                                    ],$e->getCode());

        }

        catch (Exception $e) {
            return response()->json([
                                    "message" =>$e->getMessage(),
                                    ],500);
        }
    }



    public function deleteUser(Request $request){
        
        try {
            $response = User::deleteUser($request['user_id']); 

             return response()->json([
                                    "message" => "user deleted",
                                    ],200);
        }

        catch (AppCustomHttpException $e) {

             return response()->json([
                                    "message" => $e->getMessage(),
                                    ],$e->getCode());

        }

        catch (Exception $e) {
            return response()->json([
                                    "message" =>$e->getMessage(),
                                    ],500);
        }
    }


    public function changeUserAuthId(Request $request){

        try {
            $response = User::changeUserAuthId($request['user_id']); 

             return response()->json([
                                    "message" => "authentication level changed",
                                    ],200);
        }

        catch (AppCustomHttpException $e) {

             return response()->json([
                                    "message" => $e->getMessage(),
                                    ],$e->getCode());

        }

        catch (Exception $e) {
            return response()->json([
                                    "message" =>$e->getMessage(),
                                    ],500);
        }
    }

    }



