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
   
    public function testDeleteComplaintWithInvalidId(){
        
        $response = $this->json('DELETE', '/api/v1/complaints/2000');

        $response
            ->assertStatus(404)
            ->assertExactJson([
                'message' => 'complaint not found',
            ]);
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

   
    
}