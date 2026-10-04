<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\Semester;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SemesterController extends Controller
{
    public function index(): Response
    {
        $this->authorize('courses.manage');

        $semesters = Semester::orderBy('start_date', 'desc')->paginate(10);

        return Inertia::render('Semesters/Index', [
            'semesters' => $semesters,
        ]);
    }

    public function create(): Response
    {
        $this->authorize('courses.manage');
        return Inertia::render('Semesters/Create');
    }

    public function store(StoreSemesterRequest $request): RedirectResponse
    {
        $this->authorize('courses.manage');
        Semester::create($request->validated());
        return redirect()->route('semesters.index')->with('success', 'Semester dibuat.');
    }

    public function edit(Semester $semester): Response
    {
        $this->authorize('courses.manage');
        return Inertia::render('Semesters/Edit', ['semester' => $semester]);
    }

    public function update(UpdateSemesterRequest $request, Semester $semester): RedirectResponse
    {
        $this->authorize('courses.manage');
        $semester->update($request->validated());
        return redirect()->route('semesters.index')->with('success', 'Semester diperbarui.');
    }

    public function destroy(Semester $semester): RedirectResponse
    {
        $this->authorize('courses.manage');
        $semester->delete();
        return redirect()->route('semesters.index')->with('success', 'Semester dihapus.');
    }
}
