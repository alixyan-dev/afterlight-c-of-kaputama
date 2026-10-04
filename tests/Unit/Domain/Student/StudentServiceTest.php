<?php
namespace Tests\Unit\Domain\Student;
use App\Domain\Student\StudentService;
use App\Domain\Student\StudentRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class StudentServiceTest extends TestCase
{
    use RefreshDatabase;
    protected StudentService $service;
    protected function setUp(): void { parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $this->service = new StudentService(new StudentRepository()); }
    public function test_create_student_assigns_role(): void
    {
        $user = $this->service->createStudent([
            'name' => 'Test', 'email' => 't' . time() . '@e.com', 'password' => 'pass', 'is_active' => true,
        ]);
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('mahasiswa'));
    }
}
