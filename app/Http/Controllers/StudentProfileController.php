<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentProfileRequest;
use App\Http\Requests\UpdateStudentProfileRequest;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Inertia\Inertia;

class StudentProfileController extends Controller
{
    public function index(): View
    {
        $this->authorize('students.manage');

        $profiles = StudentProfile::with('user')
            ->search(request('search'))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Students/Index', [
            'profiles' => $profiles,
        ]);
    }

    public function create(): View
    {
        $this->authorize('students.manage');

        return Inertia::render('Students/Create');
    }

    public function store(StoreStudentProfileRequest $request): RedirectResponse
    {
        $this->authorize('students.manage');

        StudentProfile::create($request->validated());

        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function show(StudentProfile $studentProfile): View
    {
        $this->authorize('view', $studentProfile);

        return Inertia::render('Students/Show', [
            'profile' => $studentProfile->load('user'),
        ]);
    }

    public function edit(StudentProfile $studentProfile): View
    {
        $this->authorize('update', $studentProfile);

        return Inertia::render('Students/Edit', [
            'profile' => $studentProfile->load('user'),
        ]);
    }

    public function update(UpdateStudentProfileRequest $request, StudentProfile $studentProfile): RedirectResponse
    {
        $this->authorize('update', $studentProfile);

        $studentProfile->update($request->validated());

        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(StudentProfile $studentProfile): RedirectResponse
    {
        $this->authorize('delete', $studentProfile);

        $studentProfile->delete();

        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
