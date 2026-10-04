<?php

namespace App\Http\Controllers;

use App\Domain\Student\StudentService;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function __construct(
        protected StudentService $studentService,
    ) {}

    /**
     * Display a listing of student users with search, filter, and sort.
     */
    public function index(): Response
    {
        $this->authorize('students.manage');

        $users = $this->studentService->listStudents(
            search: request('search'),
            status: request('status'),
            sort: request('sort', 'name'),
            direction: request('direction', 'asc'),
        );

        return Inertia::render('Students/Index', [
            'users' => $users,
            'search' => request('search'),
            'status' => request('status'),
            'sort' => request('sort', 'name'),
            'direction' => request('direction', 'asc'),
            'reset_password' => session('reset_password'),
            'reset_student_name' => session('reset_student_name'),
        ]);
    }

    /**
     * Show the form for creating a new student.
     */
    public function create(): Response
    {
        $this->authorize('students.manage');

        return Inertia::render('Students/Create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $this->authorize('students.manage');

        $this->studentService->createStudent($request->validated());

        return redirect()
            ->route('students.index')
            ->with('success', 'Akun mahasiswa berhasil dibuat.');
    }

    /**
     * Display the specified student.
     */
    public function show(User $student): Response
    {
        $this->authorize('students.manage');

        return Inertia::render('Students/Show', [
            'student' => $this->studentService->findById($student->id),
        ]);
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(User $student): Response
    {
        $this->authorize('students.manage');

        return Inertia::render('Students/Edit', [
            'student' => $student,
        ]);
    }

    /**
     * Update the specified student in storage.
     */
    public function update(UpdateStudentRequest $request, User $student): RedirectResponse
    {
        $this->authorize('students.manage');

        $this->studentService->updateStudent($student, $request->validated());

        return redirect()
            ->route('students.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(User $student): RedirectResponse
    {
        $this->authorize('students.manage');

        $this->studentService->deleteStudent($student);

        return redirect()
            ->route('students.index')
            ->with('success', 'Akun mahasiswa berhasil dihapus.');
    }

    /**
     * Reset the student password and return the generated plain-text password.
     */
    public function resetPassword(User $student): RedirectResponse
    {
        $this->authorize('students.manage');

        $plainPassword = $this->studentService->resetPassword($student);

        return back()->with([
            'reset_password' => $plainPassword,
            'reset_student_name' => $student->name,
        ]);
    }
}
