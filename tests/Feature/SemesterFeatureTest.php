<?php
namespace Tests\Feature;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class SemesterFeatureTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }
    public function test_index_shows_semesters(): void
    {
        $user = User::factory()->create();
        $user->assignRole('komting');
        $this->actingAs($user);
        $response = $this->get('/semesters');
        $response->assertStatus(200);
    }
}
