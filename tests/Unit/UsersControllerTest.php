<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    // Use RefreshDatabase to run tests against an in-memory database.
    use RefreshDatabase;

    /**
     * Test the /api/v1/users endpoint.
     */
    public function testUsersEndpoint()
    {
        // Send a GET request to the endpoint.
        $response = $this->get('/api/v1/users?provider=DataProviderX&statusCode=authorized&balanceMin=0&balanceMax=1000&currency=sar');

        // Assert that the response has a 200 status code.
        $response->assertStatus(200);

        // Assert that the response contains the expected JSON structure.
        $response->assertJsonStructure([
            '*' => [
                'id',
                'amount',
                'currency',
                'email',
                'statusCode',
                'paymentDate',
                'parentIdentification',
                'provider',
                'created_at',
                'updated_at',
            ],
        ]);
    }
}
