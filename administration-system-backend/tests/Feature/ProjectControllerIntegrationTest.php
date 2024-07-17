<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserNotification;

class ProjectControllerIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_store_a_new_project()
    {
        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $assignedUser = User::factory()->create();

        $projectData = [
            'name' => 'Test Project',
            'description' => 'Test Description',
            'status' => 'new',
            'user_id' => $assignedUser->id,
        ];

        $response = $this->postJson(route('projects.store'), $projectData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('projects', $projectData);

        Mail::assertQueued(UserNotification::class, function ($mail) use ($assignedUser) {
            return $mail->hasTo($assignedUser->email);
        });
    }
    
    // Add more integration tests for other methods
}
