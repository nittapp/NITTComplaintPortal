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
      $faker = Faker::create();
      $parentIDs = ComplaintComment::pluck('complaint_id');
      $parentID = $faker->randomElement($parentIDs->toArray());
      $response = $this->json('GET','/api/v1/comments/'.$parentID);
      $response
        ->assertStatus(200)
        ->assertJson([
                'message' => 'comments available',
                ]);
    }
    

    public function testCreateComplaintCommentsWithInvalidId(){
      $faker = Faker::create();
      $response = $this->json('POST','/api/v1/comments',['complaint_id' => 36,
                                                         'comment' => $faker->text]);
      $response
        ->assertStatus(404)
        ->assertJson([
                'message' => 'Complaint not found',
                ]); 
    }

    
    public function testCreateComplaintCommentsWithComments(){
      $faker = Faker::create();
      $parentIDs = Complaint::pluck('id');
      $parentID = $faker->randomElement($parentIDs->toArray());
      $response = $this->json('POST','/api/v1/comments',['complaint_id' => $parentID,
                                                         'comment' => $faker->text]);
      $response
        ->assertStatus(200)
        ->assertJson([
                'message' => 'comment created successfully',
                ]); 
    }
    /**
     * Unit test for editing complaint comments with complaint id and new complaint comment given
     * @return void
     */
    
    public function testEditComplaintCommentsWithInvalidId(){
         $faker = Faker::create();
         $response = $this->json('PUT','/api/v1/comments',['complaint_comment_id' => 129,
                                                           'comment' => $faker->text]);
         $response
            ->assertStatus(404)
            ->assertJson([
                    'message' => 'Comment not found',
                    ]); 
    }

    public function testEditComplaintCommentsWithValidComments(){
         $faker = Faker::create();
         $parentIDs = ComplaintComment::pluck('id');
         $parentID = $faker->randomElement($parentIDs->toArray());
         $response = $this->json('PUT','/api/v1/comments',['complaint_comment_id' => $parentID,
                                                           'comment' => $faker->text]);
         $response
            ->assertStatus(200)
            ->assertJson([
                    'message' => 'comment updated successfully',
                    ]); 
        
    }
    /**
     * Unit test for deleting complaint comments with complaintComment Id given
     * @return void
     */
    
    public function testDeleteComplaintCommentsWithInvalidId(){
        $response = $this->json('DELETE','/api/v1/comments/200');
        $response
            ->assertStatus(404)
            ->assertExactJson([
                'message' => 'Comment not found',
            ]);
    }
  
    public function testDeleteComplaintCommentsWithValidId(){
        $faker = Faker::create();
        $parentIDs = ComplaintComment::pluck('id');
        $parentID = $faker->randomElement($parentIDs->toArray());
        $response = $this->json('DELETE','/api/v1/comments/'.$parentID);
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'comment deleted successfully',
            ]);
    }

}
