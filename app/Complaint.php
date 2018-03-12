<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\ComplaintValidator;
use App\ComplaintStatus;
use App\Exceptions\AppCustomHttpException;
use Exception;
use Storage;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
//use Illuminate\Support\Facades\Storage;


class Complaint extends Model
{
    protected $table = 'complaints';
    /**
     * All Complaints are assigned a status 
     * @return App::ComplaintStatus 
     */
    public function complaintStatus(){
        return $this->belongsTo('App\ComplaintStatus','status_id');
    }
    /**
     * Each Complaints are made by a User
     * @return App::User
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /**
     * Each Complaints are made by a User
     * @return App::User
     */
    public function complaintComments(){
        return $this->hasMany('App\ComplaintComment');
    }
    /**
    * validateRequest is the function that is used to validate 
    * the inputs of the get and create routes for complaint 
    **/
    static public function validateRequest(Request $request){
          
        if($request->method() == 'POST'){
            
            $validator = Validator::make($request->all(), [
                  'title' => 'required|string|max:255',
                  'description' => 'required|string|max:1023',
            ]);


        }
        else
            $validator = Validator::make($request->all(), [
                      'title' => 'string|nullable|max:255',
                      'description' => 'nullable|string|max:1023',
            ]);
       if ($validator->fails())
             throw new AppCustomHttpException($validator->errors()->first(), 422);        
       
    }
    /**
     * This is a GET route that is for the given user to view his/her complaint
     * By using the params - userID, startDate and endDate, the complaints are retieved by the
     * available combinations of parameters of startDate & endDate.
     * @param  userID    
     * @param  startDate 
     * @param  endDate   
     * @return [array] complaints
     */
     static public function getUserComplaints(Request $request, $startDate, $endDate, $hostel = NULL){
 
        $userID = User::getUserID($request);
        if(! $userID)
             throw new AppCustomHttpException("user not logged in", 401);
        $complaints = Complaint::select('id','title','description',
                                        'image_url','status_id','created_at')
                               ->where('user_id',$userID)
                               ->get();
        
        foreach ($complaints as $complaint) {
            $complaint->status = $complaint->complaintStatus()->select('name','message')->first();
            $file_url =  (string)$userID.'/'.(string)$complaint->id.'.jpeg';
            if(Storage::disk('local')->exists($file_url))
               $complaint->image_path = $file_url;
        }
        
        if(isset($startDate))
            $complaints = $complaints->where('created_at','>=',$startDate);
        if(isset($endDate))
            $complaints = $complaints->where('created_at','<=',$endDate);
        return $complaints->values()->all(); 
    }
     /**
     * This is for the admin GET route. 
     * By using the complaint->user, complaint->status, user->hostel relationships, 
     * the data for the admin's complaint-feed is retrieved.   
     * @param  startDate 
     * @param  endDate
     * @param  hostel
     * @param  status
     * @return [array] response 
     */
    static public function getAllComplaints(Request $request, $startDate, $endDate, $hostel, $status){
         
        $userID = User::getUserID($request);
        if(! $userID)
            throw new AppCustomHttpException("user not logged in", 401);
        if(! User::isUserAdmin($request))
            throw new AppCustomHttpException("user not admin", 403);
 
         $complaints = Complaint::select('id','user_id','title','description',
                                        'status_id','image_url','is_public','created_at')
                               ->paginate(10);
        foreach ($complaints as $complaint) {
            $complaint->status = $complaint->complaintStatus()->select('name','message')->first();
            $file_url =  (string)$complaint->user_id.'/'.(string)$complaint->id.'.jpeg';
            $complaint->user = $complaint->user()->select('username','name','room_no','hostel_id',
                                                          'phone_contact','whatsapp_contact','email')
                                                 ->first();

            $complaint->image_path = $file_url;
            $complaint->user->hostel = $complaint->user->hostel()->value('name');
            //$compla
        }
        if(isset($startDate))
            $complaints = $complaints->where('created_at','>=',$startDate);
        if(isset($endDate))
            $complaints = $complaints->where('created_at','<=',$endDate);
        if(isset($status))
            $complaints = $complaints->filter(function($complaint) use($status){
                return $complaint->status->name == $status;
            });
        if(isset($hostel))
            $complaints = $complaints->filter(function($complaint) use($hostel){
                return $complaint->user->hostel == $hostel;
            });
        return $complaints->values()->all();
    }
    /**
     * This is for the user GET route for all public complaints 
     * This will for any given user return all the public complaints
     * This will be done by verifying the isPublic column in the complaint
     * @param startDate
     * @param endDate
     * @return [array] complaints
     */
        static public function getPublicComplaints(Request $request, $startDate, $endDate, $status){
         
        $userID = User::getUserID($request);
        if(! $userID)
            throw new AppCustomHttpException("user not logged in", 401);
         $complaints = Complaint::select('id','user_id','title','description',
                                        'status_id','image_url','created_at')
                               ->where('is_public',true)->get();
        foreach ($complaints as $complaint) {
            $complaint->status = $complaint->complaintStatus()->select('name','message')->first();
            $file_url =  (string)$complaint->user_id.'/'.(string)$complaint->id.'.jpeg';
            $complaint->user = $complaint->user()->select('username','name','room_no','hostel_id',
                                                          'phone_contact','whatsapp_contact','email')
                                                 ->first();
            $complaint->image_path = $file_url;                            
            $complaint->user->hostel = $complaint->user->hostel()->value('name');
        }
        if(isset($startDate))
            $complaints = $complaints->where('created_at','>=',$startDate);
        if(isset($endDate))
            $complaints = $complaints->where('created_at','<=',$endDate);
        if(isset($status))
            $complaints = $complaints->filter(function($complaint) use($status){
                return $complaint->status->name == $status;
            });
        if(isset($hostel))
            $complaints = $complaints->filter(function($complaint) use($hostel){
                return $complaint->user->hostel == $hostel;
            });
        return $complaints->values()->all();
    }

    /*
     * This is for the user DELETE route. 
     * By using the complaint id,  
     * the instance of the table with given id is deleted
     * @param id
     * @param userID
     * @return 1 for sucessfully created and 0 if not
    */
   
     static public function deleteComplaints(Request $request, $id){
        
         $userID = User::getUserID($request);
         $isUserAdmin = User::isUserAdmin($request);
     
         if(! $userID)
              throw new AppCustomHttpException("user not logged in", 401);
         if(! $isUserAdmin)
              throw new AppCustomHttpException("user not admin", 403);
 
         if(!Complaint::where('id',$id)->exists())        
            //  throw new AppCustomHttpException("complaint not found", 404);
         
         Complaint::where('id',$id)->delete();
         $file_url =  (string)$userID.'/'.(string)$id.'.jpeg';
         Storage::disk('local')->delete($file_url);         
     } 
    /**
     * This is for the user POST route. 
     * By using the complaint description, hostel name, user ID,
     * a new instance of the table is created
     * default status is referred from the ComplaintStatus model
     * @param title
     * @param  description
     * @param  image_url
     * @return 1 for sucessfully created and 0 if not
    */
    static public function createComplaints(Request $request){
     //   var_dump($request["title"]);
      //  var_dump("The description"); 
        //var_dump("description");  
        $userID = User::getUserID($request);
        if( $request->hasFile('image') )   
            if(!in_array($request->image->extension(), array('jpg','jpeg','png')))
                throw new AppCustomHttpException("Only jpeg images allowed",422);
    
        $complaintModel = new Complaint;
        $complaintModel->title = $request['title']; 
        $complaintModel->description = $request['description']; 
        $complaintModel->status_id = ComplaintStatus::initialStatus();
        $user = User::find($userID);
        $response = $user->complaints()->save($complaintModel);
        $complaint_id = $response->id; 
        if( $request->hasFile('image') )
            $path = $request->image->storeAs((string)$userID, (string)$complaint_id.'.jpeg', 'local');    
        
        //Storage::putFileAs((string)$userID,$request->file('image'),(string)$complaint_id+'.jpg');
        
        //var_dump($path);
       // Storage::disk('local')->putFileAs((string)$userID,$request->file('image'),'sss.jpg');
    }
    /**
    * This is the user PUT route
    * By using the update id, description,title and image url
    * we are update the instance of the complaint using the id given
    * @param id
    * @param title
    * @param descriSption
    * @param image_url
    * @return 1 for sucessfully created and 0 if not
    */

     static public function editComplaints(Request $request){

        $userID = User::getUserID($request);
        $complaint = Complaint::find($request["complaint_id"]);

        if(! $userID)
             throw new AppCustomHttpException("user not logged in", 401);
        if(empty($complaint))
            throw new AppCustomHttpException("Complaint not found",404);
        
        if($complaint->user_id != User::getUserID($request) &&
           ! User::isUserAdmin($request) &&
           ! Status::is_editable($complaint->status_id))
            throw new AppCustomHttpException("Action not allowed",403);

        if( $request->hasFile('image') )   
            if(!in_array($request->image->extension(), array('jpg','jpeg','png')))
                throw new AppCustomHttpException("Only jpeg images allowed",422);
        
        $complaint->title = $request['title']; 
        $complaint->description = $request['description']; 
        $complaint->save();
        
        if( $request->hasFile('image') )
         {
            $file_url =  (string)$userID.'/'.(string)$request['complaint_id'].'.jpeg';
            Storage::disk('local')->delete($file_url);         
            $path = $request->image->storeAs((string)$userID, (string)$request['complaint_id'].'.jpeg', 'local');    
        }

    }

    /**
     * This is for the PUT route for changing the complaint status 
     * The admin can change the status of a complaint and set to any of the available statuses
     * @param  [INT] $complaintID [description]
     * @param  [INT] $status_id   [description]
     * @return [STATUS] return if the status was successfully updated
     */
    static public function editComplaintStatus(Request $request, $complaintID, $statusID) {
        if(! User::isUserAdmin($request))
            throw new AppCustomHttpException("action not allowed", 403);
        $complaint = Complaint::find($complaintID);
        
        if(empty($complaint))
            throw new AppCustomHttpException("complaint not found", 404);
         
        $complaint->status_id = $statusID;
        $complaint->save();
    }
     /**
     * THis is for the PUT route for changing the isPublic property of a complaint
     * The admin can change the status of a complaint and set to any of the available statuses
     * @param  [INT] $complaintID [description]
     * @return [STATUS] return if isPublic was successfully toggled
     */
    static public function editIsPublicStatus(Request $request, $complaintID){
        if(! User::isUserAdmin($request))
            throw new AppCustomHttpException("action not allowed",403);
        $complaint = Complaint::find($complaintID);
        if(empty($complaint))
             throw new AppCustomHttpException("complaint not found", 404);
        $complaint->is_public = !$complaint->is_public; 
        $complaint->save();
    }
}