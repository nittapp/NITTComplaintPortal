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
class ComplaintCommentTest extends TestCase
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


    public function testGetComplaintCommentsWithInvalidId(){
      $response = $this->json('GET','/api/v1/comments/100');
      $response
        ->assertStatus(404)
        ->assertJson([
                'message' => 'Complaint not found',
                ]);
    }

    public function testGetComplaintCommentsWithValidId(){
      $response = $this->json('GET','/api/v1/comments/4');
      $response
        ->assertStatus(404)
        ->assertJson([
                'message' => 'comments available',
            
                ]);
    }
    


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

        $response = $this->json('DELETE', '/v1/comments/20');

        $response
            ->assertStatus(404)
            ->assertExactJson([
                'message' => 'Comment not found',
            ]);
    }
  
    public function testDeleteComplaintCommentsWithValidId(){
         $complaintCommentId = 9;
         $response = ComplaintComment::deleteComplaintComments($complaintCommentId);
         $this->assertEquals(NULL,$response);
    }
}
