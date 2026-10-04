<?php
namespace Tests\Feature;
use App\Models\User;
use Tests\TestCase;
class SemesterFeatureTest extends TestCase
{
    public function test_index_shows_semesters(): void
    {
        $user = User::factory()->create();
        $user->assignRole('komting');
        $this->actingAs($user);
        $response = $this->get('/semesters');
        $response->assertStatus(200);
    }
}
