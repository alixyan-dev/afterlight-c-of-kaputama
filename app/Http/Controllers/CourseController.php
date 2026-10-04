<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function index(): Response
    {
        $this->authorize('courses.manage');

        return Inertia::render('Courses/Index', [
            'courses' => Course::with('semester')->paginate(10),
        ]);
    }

    public function create(): Response
    {
        $this->authorize('courses.manage');
        return Inertia::render('Courses/Create');
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $this->authorize('courses.manage');
        Course::create($request->validated());
        return redirect('/courses')->with('success', 'Mata kuliah dibuat.');
    }

    public function edit(Course $course): Response
    {
        $this->authorize('courses.manage');
        return Inertia::render('Courses/Edit', ['course' => $course]);
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $this->authorize('courses.manage');
        $course->update($request->validated());
        return redirect('/courses')->with('success', 'Mata kuliah diperbarui.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('courses.manage');
        $course->delete();
        return redirect('/courses')->with('success', 'Mata kuliah dihapus.');
    }
}
