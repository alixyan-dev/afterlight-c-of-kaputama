<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Meeting;
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
        return Inertia::render('Meetings/Create');
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
        return Inertia::render('Meetings/Edit', ['meeting' => $meeting]);
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('meetings.update');
        $meeting->update($request->validated());
        return redirect('/meetings')->with('success', 'Pertemuan diperbarui.');
    }

    public function destroy(Meeting $meeting): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('meetings.delete');
        $meeting->delete();
        return redirect('/meetings')->with('success', 'Pertemuan dihapus.');
    }
}
