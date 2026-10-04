<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Activitylog\Facades\Activity;

class StudentController extends Controller
{
    /**
     * Display a listing of student users with search, filter, and sort.
     */
    public function index(): Response
    {
        $this->authorize('students.manage');

        $users = User::with('roles')
            ->whereHas('roles', fn ($q) => $q->where('name', 'mahasiswa'));

        // Search by name or email
        $search = request('search');
        if ($search) {
            $users->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        // Filter by status
        $status = request('status');
        if ($status === 'active') {
            $users->where('is_active', true);
        } elseif ($status === 'inactive') {
            $users->where('is_active', false);
        }

        // Sort
        $allowedSorts = ['name', 'email', 'is_active', 'created_at'];
        $sort = request('sort', 'name');
        $direction = request('direction', 'asc');

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'name';
        }

        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';
        $users->orderBy($sort, $direction);

        $users = $users->paginate(10)->withQueryString();

        return Inertia::render('Students/Index', [
            'users' => $users,
            'search' => $search,
            'status' => request('status'),
            'sort' => $sort,
            'direction' => $direction,
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

        $user = User::create($request->validated());
        $user->assignRole('mahasiswa');

        Activity::causedBy(auth()->user())
            ->performedOn($user)
            ->log('Akun mahasiswa dibuat');

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
            'student' => $student->load('roles', 'studentProfile'),
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

        $student->update($request->validated());

        Activity::causedBy(auth()->user())
            ->performedOn($student)
            ->log('Data akun mahasiswa diperbarui');

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

        Activity::causedBy(auth()->user())
            ->performedOn($student)
            ->log('Akun mahasiswa dihapus');

        $student->delete();

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

        $plainPassword = Str::random(4).'-'.Str::random(4).'-'.Str::random(4);

        $student->update(['password' => $plainPassword]);

        Activity::causedBy(auth()->user())
            ->performedOn($student)
            ->log('Password direset');

        return back()->with([
            'reset_password' => $plainPassword,
            'reset_student_name' => $student->name,
        ]);
    }
}
