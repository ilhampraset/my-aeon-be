<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index method returns success message.
     *
     * @return void
     */
    public function test_application_return_success_message()
    {
        User::factory()->count(10)->create();


        $response = $this->get('/api/users');

        $response->assertStatus(200)->assertJson([
            'code' => 200,
            'message' => 'Success Retrieve Data',
            'data' => [
                'current_page' => 1,
                'total' => 10,
                'data' => [],
            ],
        ])->assertJsonFragment(['message' => 'Success Retrieve Data']);
    }

    /**
     * Test index method returns correct data and structure.
     *
     * @return void
     */
    public function test_application_return_correct_data()
    {
        $users = User::factory()->count(5)->create();

        $response = $this->get('/api/users');

        $response->assertStatus(200)->assertJsonStructure($this->expectedJsonStructure());

        $data = $response->decodeResponseJson();
        $countData= count($data['data']['data']);
        $this->assertEquals(count($users), $countData);

    }

    /**
     * Test show method returns correct response for valid user id.
     *
     * @return void
     */

    public function test_show_method_returns_correct_response_for_valid_user_id()
    {

        $user = User::factory()->create();

        $response = $this->get('/api/users/' . $user->id);

        $response->assertStatus(200)
            ->assertJson([
                'code' => 200,
                'message' => 'Success Retrieve Data',
                'data' => $user->toArray()
            ]);
    }

    /**
     * Test show method returns error for invalid user id.
     *
     * @return void
     */
    public function test_show_method_returns_error_for_invalid_user_id()
    {
        $invalidUserId = 9999;
        $user = User::factory()->create();
        $response = $this->get('/api/users/' . $invalidUserId);

        $response->assertStatus(404)
            ->assertJson([
                'code' => 404,
                'message' => 'Failed Retrieve Data',
                'errors' => ['No query results for model [App\\Models\\User] 9999']
            ]);
    }

    /**
     * Get the expected JSON structure for the response.
     *
     * @return array
     */
    private function expectedJsonStructure(): array
    {
        return [
            'code',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'profile_picture',
                        'email_verified_at',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ],
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
        ];
    }
}
