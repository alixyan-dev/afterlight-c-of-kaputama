<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Course;
use App\Models\Meeting;
use App\Models\Semester;
use Inertia\Inertia;
use Inertia\Response;

class MeetingController extends Controller
{
    public function index(): Response
    {
        $this->authorize('meetings.view');
        return Inertia::render('Meetings/Index', [
            'meetings' => Meeting::with('course', 'semester')->paginate(10),
        ]);
    }

    public function create(): Response
    {
        $this->authorize('meetings.create');
        return Inertia::render('Meetings/Create', [
            'courses' => Course::orderBy('name')->get(),
            'semesters' => Semester::orderBy('start_date', 'desc')->get(),
        ]);
    }

    public function store(StoreMeetingRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('meetings.create');
        Meeting::create(array_merge($request->validated(), ['status' => 'draft']));
        return redirect('/meetings')->with('success', 'Pertemuan dibuat.');
    }

    public function edit(Meeting $meeting): Response
    {
        $this->authorize('meetings.update');
        return Inertia::render('Meetings/Edit', [
            'meeting' => $meeting,
            'courses' => Course::orderBy('name')->get(),
            'semesters' => Semester::orderBy('start_date', 'desc')->get(),
        ]);
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('meetings.update');
        $meeting->update($request->validated());
        return redirect('/meetings')->with('success', 'Pertemuan diperbarui.');
    }

    public function submit(Meeting $meeting): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('meetings.submit');
        $meeting->update(['status' => 'submitted']);
        return redirect('/meetings')->with('success', 'Pertemuan diajukan.');
    }

    public function validate(Meeting $meeting): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('meetings.validate');
        $meeting->update(['status' => 'validated', 'validated_by' => auth()->id(), 'validated_at' => now()]);
        return redirect('/meetings')->with('success', 'Pertemuan divalidasi.');
    }

    public function destroy(Meeting $meeting): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('meetings.delete');
        $meeting->delete();
        return redirect('/meetings')->with('success', 'Pertemuan dihapus.');
    }
}
