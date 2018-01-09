<?php 

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Complaint;


class ComplaintValidator extends Model{
	public function validateArguements($title,$description,$image_url=null){
		return $request->validate([
        'title' => 'required|alpha_num|max:255',
        'description' => 'required|alpha_num|max:1023',
        'image_url' => 'nullable|active_url'
     ]);
   }
}

?>