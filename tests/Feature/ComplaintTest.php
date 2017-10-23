<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComplaintTest extends TestCase
{
    /**
     * Test for getting all the complaints made by a logged in user
     * @return void
     */
    public function testNormalLoggedInUserGetComplaintsWithNoDates() {
        $response = $this->get('api/v1/complaints');

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'complaints available',
            ])
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'image_url',
                        'created_at',
                    ],
                ],
            ]);
    }

}
