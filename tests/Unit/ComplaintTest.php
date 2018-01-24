<?php
namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Complaint;
use App\ComplaintComment;
use App\ComplaintReply;
use App\ComplaintStatus;
use App\Hostel;
class ComplaintTest extends TestCase
{  
 /**
     * Unit test for getting complaints with no date filters
     * @return void
     */
    public function testGetUserComplaintsWithNoDatesFilters() {
        $startDate = NULL;
        $endDate = NULL;
        $complaints = Complaint::getUserComplaints($startDate, $endDate);
        foreach ($complaints as $complaint) {
            $this->assertArrayHasKey('id', $complaint);
            $this->assertArrayHasKey('title', $complaint);
            $this->assertArrayHasKey('description', $complaint);
            $this->assertArrayHasKey('image_url', $complaint);
            $this->assertArrayHasKey('created_at', $complaint);
        }
    }
    /**
     * Unit test for getting complaints with only start date given
     * @return void
     */
    public function testGetUserComplaintsWithStartDateFilter() {
        $startDate = '2017-10-11 00:00:00';
        $endDate = NULL;
        $complaints = Complaint::getUserComplaints($startDate, $endDate);
        foreach ($complaints as $complaint) {
            $this->assertArrayHasKey('id', $complaint);
            $this->assertArrayHasKey('title', $complaint);
            $this->assertArrayHasKey('description', $complaint);
            $this->assertArrayHasKey('image_url', $complaint);
            $this->assertArrayHasKey('created_at', $complaint);
            $this->assertEquals(true, ($complaint['created_at'] >= $startDate));
        }
    }
    /**
     * Unit test for getting complaints with both start date and end date given
     * @return void
     */
    public function testGetUserComplaintsWithStartDateAndEndDate() {
        $startDate = '2017-10-13 00:00:00';
        $endDate = '2017-10-17 00:00:00';
        $complaints = Complaint::getUserComplaints($startDate, $endDate);
        foreach ($complaints as $complaint) {
            $this->assertArrayHasKey('id', $complaint);
            $this->assertArrayHasKey('title', $complaint);
            $this->assertArrayHasKey('description', $complaint);
            $this->assertArrayHasKey('image_url', $complaint);
            $this->assertArrayHasKey('created_at', $complaint);
            $this->assertEquals(true, (($complaint['created_at'] >= $startDate) &&
                                       ($complaint['created_at'] <= $endDate)
                                      )
                               );
        }
    }
    public function testGetAllComplaintsWithStartDateEndDateHostelAndStatus() {
        $startDate = '2017-10-13 00:00:00';
        $endDate = '2017-10-17 00:00:00';
        $hostel = Hostel::where('id', 3)
                        ->value('name');
        $status = ComplaintStatus::where('id', 3)
                                 ->value('name');
        $complaints = Complaint::getAllComplaints($startDate, $endDate, $hostel, $status);
        foreach ($complaints as $complaint) {
            $this->assertArrayHasKey('id', $complaint);
            $this->assertArrayHasKey('title', $complaint);
            $this->assertArrayHasKey('description', $complaint);
            $this->assertArrayHasKey('image_url', $complaint);
            $this->assertArrayHasKey('created_at', $complaint);
            $this->assertEquals(true, (($complaint['created_at'] >= $startDate) &&
                                       ($complaint['created_at'] <= $endDate) &&
                                       ($complaint->user->hostel == $hostel) &&
                                       ($complaint->status->name == $status)
                                      )
                               );
        }
    }
    /**
     * Unit test for deleting complaints with id given
     * @return void
     */
    public function testDeleteComplaintWithInvalidId() {
         $complaintId = 25;
         $response = Complaint::deleteComplaints($complaintId);
         //$this->assertEquals("complaints available",response()->json("message");
         $this->assertEquals(NULL,$response);
    }
    
    public function testDeleteComplaintWithValidId() {
         $complaintId = 11;
         $response = Complaint::deleteComplaints($complaintId);
         //$this->assertEquals("complaint deleted",response()->json(["message"]);
         $this->assertEquals(NULL,$response);
    }
   
    public function testCreateNewComplaintWithoutUrl() {
         $faker = Faker::create();
         $title = $faker->sentence;
         $description = $faker->text;
         $imageURL = NULL;
         $complaints = Complaint::createComplaints($title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);
    }

    public function testCreateNewComplaintWithUrl(){
         $faker = Faker::create();
         $title = $faker->sentence;
         $description = $faker->text;
         $imageURL = $faker->imageUrl;
         $complaints = Complaint::createComplaints($title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);  
    }

    public function testCreateNewComplaintWithoutTitle(){
         $faker = Faker::create();
         $title = NULL;
         $description = $faker->text;
         $imageURL = $faker->imageUrl;
         $complaints = Complaint::createComplaints($title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);
    }

    public function testCreateNewComplaintWithInvalidTitle(){
         $faker = Faker::create();
         $title =  $faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}');
         $description = $faker->text;
         $imageURL = $faker->imageUrl;
         $complaints = Complaint::createComplaints($title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);
    }

    public function testCreateNewComplaintWithOutOfBoundsTitle(){
         $faker = Faker::create();
         $title =  $faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}');
         $description = $faker->text($maxNbChars = 2000);
         $imageURL = $faker->imageUrl;
         $complaints = Complaint::createComplaints($title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);
    }

    public function testEditComplaintWithCorrectParameters(){
         $faker = Faker::create();
         $title =  $faker->sentence;
         $description = $faker->text($maxNbChars = 900);
         $imageURL = $faker->imageUrl;
         $complaint_id = 7;
         $complaints = Complaint::editComplaints($complaint_id,$title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);
    }

    public function testEditComplaintWithoutAnyParameters(){
         $faker = Faker::create();
         $title =  NULL;
         $description = NULL;
         $imageURL = NULL;
         $complaint_id = 7;
         $complaints = Complaint::editComplaints($complaint_id,$title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);
    }

    public function testEditComplaintWithOutOfBoundsTitle(){
         $faker = Faker::create();
         $title = $faker->sentence($maxNbChars=2000);
         $description = $faker->text($maxNbChars = 900);
         $imageURL = $faker->imageUrl;
         $complaint_id = 7;
         $complaints = Complaint::editComplaints($complaint_id,$title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);
    }

    public function testEditComplaintWithNoImageUrl(){
         $faker = Faker::create();
         $title = $faker->sentence;
         $description = $faker->text($maxNbChars = 900);
         $imageURL = NULL;
         $complaint_id = 7;
         $complaints = Complaint::editComplaints($complaint_id,$title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);
    }

    public function testEditComplaintWithNoTitle(){
         $faker = Faker::create();
         $title = NULL;
         $description = $faker->text($maxNbChars = 900);
         $imageURL = $faker->imageUrl;
         $complaint_id = 7;
         $complaints = Complaint::editComplaints($complaint_id,$title,$description,$imageURL);
         $this->assertEquals(NULL,$complaints);
   }

/**
     * Unit test for getting complaint comments with id
     * @return void
     */
    public function testGetComplaintCommentsWithoutId(){
      $id = NULL;
      $complaintComments = ComplaintComment::getComplaintComments($id);
        foreach ($complaintComments as $complaintComment) {
            $this->assertArrayNotHasKey('id', $complaintComment);
            $this->assertArrayNotHasKey('comment', $complaintComment);
            $this->assertArrayNotHasKey('created_at', $complaintComment);
            $this->assertArrayNotHasKey('updated_at', $complaintComment);
        }
    }
    public function testGetComplaintCommentsWithInvalidId(){
      $id = 100;
      $complaintComments = ComplaintComment::getComplaintComments($id);
       foreach ($complaintComments as $complaintComment) {
            $this->assertArrayNotHasKey('id', $complaintComment);
            $this->assertArrayNotHasKey('comment', $complaintComment);
            $this->assertArrayNotHasKey('created_at', $complaintComment);
            $this->assertArrayNotHasKey('updated_at', $complaintComment);
        }
    }
    public function testGetComplaintCommentsWithValidId(){
      $id = 17;
      $complaintComments = ComplaintComment::getComplaintComments($id);
       foreach ($complaintComments as $complaintComment) {
            $this->assertArrayHasKey('id', $complaintComment);
            $this->assertArrayHasKey('comment', $complaintComment);
            $this->assertArrayHasKey('created_at', $complaintComment);
            $this->assertArrayHasKey('updated_at', $complaintComment);
        }
    }
    /**
     * Unit tests for creating new complaint comments with comments given
     * @return void
     */
    
    public function testCreateComplaintCommentsWithInvalidId(){
          $faker = Faker::create();
          $comment = $faker->text;
          $complaintId = 36;
          $complaintComment = ComplaintComment::createComplaintComments($complaintId,$comment);
          $this->assertEquals(NULL,$complaintComment); 
    }
    
    public function testCreateComplaintCommentsWithComments(){
          $faker = Faker::create();
          $comment = $faker->text;
          $complaintId = 8;
          $complaintComment = ComplaintComment::createComplaintComments($complaintId,$comment);
          $this->assertEquals(NULL,$complaintComment);
    }
    /**
     * Unit test for editing complaint comments with complaint id and new complaint comment given
     * @return void
     */
    
    public function testEditComplaintCommentsWithInvalidId(){
         $faker = Faker::create();
         $comment = $faker->text;
         $complaintCommentId = 44;
         $complaintComment = ComplaintComment::editComplaintComments($complaintCommentId,$comment);
         $this->assertEquals(NULL,$complaintComment);
    }

    public function testEditComplaintCommentsWithValidComments(){
         $faker = Faker::create();
         $comment = $faker->text;
         $complaintCommentId = 9;
         $complaintComment = ComplaintComment::editComplaintComments($complaintCommentId,$comment);
         $this->assertEquals(NULL,$complaintComment);
    }
    /**
     * Unit test for deleting complaint comments with complaintComment Id given
     * @return void
     */
    
    public function testDeleteComplaintCommentsWithInvalidId(){
         $complaintCommentId = 50;
         $response = ComplaintComment::deleteComplaintComments($complaintCommentId);
         $this->assertEquals(NULL,$response);
    }
  
    public function testDeleteComplaintCommentsWithValidId(){
         $complaintCommentId = 9;
         $response = ComplaintComment::deleteComplaintComments($complaintCommentId);
         $this->assertEquals(NULL,$response);
    }
    /**
     * Unit test for getting complaint replies with id
     * @return void
     */
    public function testGetComplaintRepliesWithoutId(){
      $complaintCommentId = NULL;
      $complaintReplies = ComplaintReply::getComplaintReplies($complaintCommentId);
        foreach ($complaintReplies as $complaintReply) {
            $this->assertArrayHasKey('id', $complaintReply);
            $this->assertArrayHasKey('parent_id', $complaintReply);
            $this->assertArrayHasKey('user_id', $complaintReply);
            $this->assertArrayHasKey('comment', $complaintReply);
            $this->assertArrayHasKey('created_at', $complaintReply);
            $this->assertArrayHasKey('updated_at', $complaintReply);
        }
    } 
    public function testGetComplaintRepliesWithInvalidId(){
      $complaintCommentId = 40;
      $complaintReplies = ComplaintReply::getComplaintReplies($complaintCommentId);
        foreach ($complaintReplies as $complaintReply) {
            $this->assertArrayNotHasKey('id', $complaintReply);
            $this->assertArrayNotHasKey('parent_id', $complaintReply);
            $this->assertArrayNotHasKey('user_id', $complaintReply);
            $this->assertArrayNotHasKey('comment', $complaintReply);
            $this->assertArrayNotHasKey('created_at', $complaintReply);
            $this->assertArrayNotHasKey('updated_at', $complaintReply);
        }
    } 
    
    public function testGetComplaintRepliesWithId(){
      $complaintCommentId = 8;
      $complaintReplies = ComplaintReply::getComplaintReplies($complaintCommentId);
        foreach ($complaintReplies as $complaintReply) {
            $this->assertArrayHasKey('id', $complaintReply);
            $this->assertArrayHasKey('parent_id', $complaintReply);
            $this->assertArrayHasKey('user_id', $complaintReply);
            $this->assertArrayHasKey('comment', $complaintReply);
            $this->assertArrayHasKey('created_at', $complaintReply);
            $this->assertArrayHasKey('updated_at', $complaintReply);
      }
    } 
    /**
     * Unit tests for creating new complaint replies with replies given
     * @return void
     */
    public function testCreateComplaintRepliesWithInvalidId(){
         $faker = Faker::create();
         $reply = $faker->text;
         $complaintCommentId = 40;
         $complaintReply = ComplaintReply::createComplaintReplies($complaintCommentId,$reply);
         $this->assertEquals(NULL,$complaintReply);
    }
    
    public function testCreateComplaintRepliesWithValidId(){
         $faker = Faker::create();
         $reply = $faker->text;
         $complaintCommentId = 4;
         $complaintReply = ComplaintReply::createComplaintReplies($complaintCommentId,$reply);
         $this->assertEquals(NULL,$complaintReply);
    }
     /**
     * Unit test for editing complaint replies with complaint comment id and new complaint reply given
     * @return void
     */
    
    public function testEditComplaintRepliesWithInvalidId(){
         $faker = Faker::create();
         $reply = $faker->text;
         $complaintReplyId = 15;
         $complaintReply = ComplaintReply::editComplaintReplies($complaintReplyId,$reply);
         $this->assertEquals(NULL,$complaintReply); 
    }

    public function testEditComplaintRepliesWithValidReply(){
         $faker = Faker::create();
         $reply = $faker->text;
         $complaintReplyId = 4;
         $complaintReply = ComplaintReply::editComplaintReplies($complaintReplyId,$reply);
         $this->assertEquals(NULL,$complaintReply);
     }
    /**
     * Unit test for deleting complaint replies with complaintReply Id given
     * @return void
     */
    
    public function testDeleteComplaintRepliesWithInvalidId(){
         $complaintReplyId = 30;
         $response = ComplaintReply::deleteComplaintReplies($complaintReplyId);
         $this->assertEquals(NULL,$response);
    }
    public function testDeleteComplaintRepliesWithValidId(){
         $complaintReplyId = 2;
         $response = ComplaintReply::deleteComplaintReplies($complaintReplyId);
         $this->assertEquals(NULL,$response);
    }
}
