<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(): Response
    {
        $this->authorize('students.manage');

        $users = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('name', 'mahasiswa');
            })
            ->search(request('search'))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Students/Index', [
            'users' => $users,
            'roles' => Role::all(['name', 'id']),
        ]);
    }

    public function create(): Response
    {
        $this->authorize('students.manage');

        return Inertia::render('Students/Create');
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $this->authorize('students.manage');

        $user = User::create($request->validated());
        $user->assignRole('mahasiswa');

        return redirect()->route('students.index')->with('success', 'Akun mahasiswa berhasil dibuat.');
    }

    public function show(User $user): Response
    {
        $this->authorize('students.manage');

        return Inertia::render('Students/Show', [
            'student' => $user->load('roles'),
        ]);
    }

    public function edit(User $user): Response
    {
        $this->authorize('students.manage');

        return Inertia::render('Students/Edit', [
            'student' => $user->load('roles'),
        ]);
    }

    public function update(UpdateStudentRequest $request, User $user): RedirectResponse
    {
        $this->authorize('students.manage');

        $user->update($request->validated());

        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('students.manage');

        $user->delete();

        return redirect()->route('students.index')->with('success', 'Akun mahasiswa berhasil dihapus.');
    }
}
