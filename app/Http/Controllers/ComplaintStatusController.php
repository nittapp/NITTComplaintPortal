<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ComplaintStatus;
use Exceptions;
use App\Exceptions\AppCustomHttpException;

class ComplaintStatusController extends Controller
{
    public function getComplaintStatuses (Request $request) {
        
        try {
            $complaintStatuses = ComplaintStatus::all();

            $complaintStatuses->each(function($complaintStatus) {
                unset($complaintStatus['created_at']);
                unset($complaintStatus['updated_at']);
            });

            return response()->json([
                "message"   => "statuses available",
                "data"      => $complaintStatuses,
            ], 200);
        }
        catch (AppCustomHttpException $e) {
            return response()->json([
                "message" => $e->getMessage(),
            ], $e->getCode());
        }
        catch (Exception $e) {
            return response()->json([
                "message" => "Internal Server Error",
            ], 500);
        }
    }
}
