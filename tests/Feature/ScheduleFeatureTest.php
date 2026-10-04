<?php
namespace Tests\Feature;
use App\Models\User;
use Tests\TestCase;
class ScheduleFeatureTest extends TestCase
{
    public function test_schedule_page_loads(): void
    {
        $user = User::factory()->create();
        $user->assignRole('komting');
        $this->actingAs($user);
        $response = $this->get('/schedule');
        $response->assertStatus(200);
    }
}
