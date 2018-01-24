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

class ComplaintRepliesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
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
