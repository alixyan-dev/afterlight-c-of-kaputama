<?php
namespace Tests\Feature;
use App\Models\User;
use Tests\TestCase;
class CourseFeatureTest extends TestCase
{
    public function test_index_shows_courses(): void
    {
        $user = User::factory()->create();
        $user->assignRole('komting');
        $this->actingAs($user);
        $response = $this->get('/courses');
        $response->assertStatus(200);
    }
}
