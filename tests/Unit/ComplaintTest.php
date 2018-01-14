<?php
namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Faker\Generator as Faker;
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
         $complaintId = 22;

         $response = Complaint::deleteComplaint($complaintId);
         $this->assertEquals(NULL,$response);
    }
    
    public function testDeleteComplaintWithValidId() {
         $complaintId = 2;

         $response = Complaint::deleteComplaint($complaintId);
         $this->assertEquals(NULL,$response);
    }

/*
    $faker = Faker\Factory::create()
    public function testCreateNewComplaintWithoutUrl() {
        
        $complaints = Complaint::createComplaints(
              "title" => $faker->sentence,
              "description" => $faker->text
            );
    }
    public function testCreateNewComplaintWithUrl(){
          $complaints = Complaint::createComplaints(
              "title" => $faker->sentence,
              "description" => $faker->text,
              "image_url" => $faker->imageUrl
            );
    }
    public function testCreateNewComplaintWithoutTitle(){
           $complaints = Complaint::createComplaints(
              "description" => $faker->text
            );
    }
    public function testCreateNewComplaintWithInvalidTitle(){
              $complaints = Complaint::createComplaints(
              "title" => $faker->regexify('[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}'),
              "description" => $faker->text
            );
    }
    public function testCreateNewComplaintWithOutOfBoundsTitle(){
       
        $complaints = Complaint::createComplaints(
              "title" => $faker->sentence,
              "description" => $faker->text($maxNbChars = 2000)
            );
    }
*/
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
          $comment = $faker->text;
          $complaintId = 30;
          $complaintComment = ComplaintComment::createComplaintComments($complaintId,$comment);
    }
    
    public function testCreateComplaintCommentsWithOutOfBoundsComments(){
          $comment = $faker->text($maxNbChars = 2000);
          $complaintId = 8;
          $complaintComment = ComplaintComment::createComplaintComments($complaintId,$comment);
    }
    
    public function testCreateComplaintCommentsWithComments(){
          $comment = $faker->text;
          $complaintId = 8;
          $complaintComment = ComplaintComment::createComplaintComments($complaintId,$comment);
    }

    /**
     * Unit test for editing complaint comments with complaint id and new complaint comment given
     * @return void
     */
    
    public function testEditComplaintCommentsWithInvalidId(){
          $comment = $faker->text;
          $complaintCommentId = 28;
          $complaintComment = ComplaintComment::editComplaintComments($complaintCommentId,$comment);
    }

    public function testEditComplaintCommentsWithOutOfBoundsComments(){
          $comment = $faker->text($maxNbChars = 2000);
          $complaintCommentId = 6;
          $complaintComment = ComplaintComment::editComplaintComments($complaintCommentId,$comment);
    }
     
    public function testEditComplaintCommentsWithValidComments(){
          $comment = $faker->text($maxNbChars = 2000);
          $complaintCommentId = 2;
          $complaintComment = ComplaintComment::editComplaintComments($complaintCommentId,$comment);
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
         $complaintCommentId = 10;

         $response = ComplaintComment::deleteComplaintComments($complaintCommentId);
         $this->assertEquals(NULL,$response);
    }
}