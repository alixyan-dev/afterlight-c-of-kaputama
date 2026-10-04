<?php
namespace Tests\Feature;
use App\Models\User;
use Tests\TestCase;
class StudentManagementFeatureTest extends TestCase
{
    public function test_index_shows_students(): void
    {
        $user = User::factory()->create();
        $user->assignRole('komting');
        $this->actingAs($user);
        $response = $this->get('/students');
        $response->assertStatus(200);
    }
}
