<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_return_a_list_of_projects()
    {
        $user = User::factory()->create();
        $this->actingAs($user, '/api/v1/projects');

        Project::factory()->count(5)->create();

         // Act
         $response = $this->get('/api/v1/projects');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'description', 'status', 'user_id', 'created_at', 'updated_at']
            ],
            'links',
            'meta'
        ]);
    }
}
