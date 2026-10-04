<?php
namespace Tests\Unit\Domain\Student;
use App\Domain\Student\StudentRepository;
use Tests\TestCase;
class StudentRepositoryTest extends TestCase
{
    protected StudentRepository $repo;
    protected function setUp(): void { parent::setUp(); $this->repo = new StudentRepository(); }
    public function test_find_all_with_filters(): void
    {
        $result = $this->repo->findAllWithFilters();
        $this->assertNotNull($result);
    }
}
