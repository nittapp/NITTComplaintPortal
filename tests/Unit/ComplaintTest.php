<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Complaint;

class ComplaintTest extends TestCase
{   
    
    /**
     * Unit test for getting complaints with no date filters
     * @return void
     */
    public function testGetComplaintsWithNoDatesFilters() {
        $userID = 2;
        $startDate = NULL;
        $endDate = NULL;

        $complaints = Complaint::getComplaints($userID, $startDate, $endDate);

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
    public function testGetComplaintsWithStartDateFilter() {
        $userID = 2;
        $startDate = '2017-10-11 00:00:00';
        $endDate = NULL;

        $complaints = Complaint::getComplaints($userID, $startDate, $endDate);

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
    public function testGetComplaintsWithStartDateAndEndDate() {
        $userID = 2;
        $startDate = '2017-10-13 00:00:00';
        $endDate = '2017-10-17 00:00:00';

        $complaints = Complaint::getComplaints($userID, $startDate, $endDate);

        foreach ($complaints as $complaint) {
            $this->assertArrayHasKey('id', $complaint);
            $this->assertArrayHasKey('title', $complaint);
            $this->assertArrayHasKey('description', $complaint);
            $this->assertArrayHasKey('image_url', $complaint);
            $this->assertArrayHasKey('created_at', $complaint);
            $this->assertEquals(true, (($complaint['created_at'] >= $startDate) && ($complaint['created_at'] <= $endDate)));
        }
    }

    /**
     * Unit test for deleting complaints with id given
     * @return void
     */
    public function testDeleteComplaintWithInvalidId() {
         $complaintId = 22;

         $response = Complaint::deleteComplaint($complaintId);
         $this->assertEquals("complaint doesn't exist",$response['message']);
    }
    
    public function testDeleteComplaintWithValidId() {
         $complaintId = 2;

         $response = Complaint::deleteComplaint($complaintId);
         $this->assertEquals(200,$response->status());    
    }

}
