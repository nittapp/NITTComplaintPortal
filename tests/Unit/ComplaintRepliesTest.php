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
        $id = 500; 
        $comment = "THis is a reply";
        $response = $this->json('POST', '/api/v1/replies',['parent_id' =>$id, 'comment' => $comment]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'reply created successfully',
            ]);
    }
  


    public function testCreateComplaintRepliesWithValidId(){
        $id = 5; 
        $comment = "THis is a reply";
        $response = $this->json('POST', '/api/v1/replies',['parent_id' =>$id, 'comment' => $comment]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'reply created successfully',
            ]);
    }
     /**
     * Unit test for editing complaint replies with complaint comment id and new complaint reply given
     * @return void
     */
    




    public function testEditComplaintRepliesWithInvalidReply(){

        $complaintReplyID = 4; 
        $response = $this->json('PUT', '/api/v1/replies',['complaint_comment_id' => $complaintReplyID, 'comment' =>'']);
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'reply updated successfully',
            ]);
    }
  

    public function testEditComplaintRepliesWithValidReply(){

        $complaintReplyID = 4; 
        $comment = "This is a reply";
        $response = $this->json('PUT', '/api/v1/replies',['complaint_comment_id' => $complaintReplyID,'comment' => $comment]);
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'reply updated successfully',
            ]);
    }
    /**
     * Unit test for deleting complaint replies with complaintReply Id given
     * @return void
     */
    

    public function testDeleteComplaintRepliesWithInvalidId(){
        
        $response = $this->json('DELETE', '/api/v1/replies/2000');

        $response
            ->assertStatus(404)
            ->assertExactJson([
                'message' => 'reply not found',
            ]);
    }

    public function testDeleteComplaintRepliesWithValidId(){
        
        $response = $this->json('DELETE', '/api/v1/replies/2');

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'reply deleted successfully',
            ]);
    }
    
}
