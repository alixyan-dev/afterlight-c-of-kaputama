<?php
namespace App\Http\Controllers;
use App\Models\Semester;
use Inertia\Inertia;
use Inertia\Response;
class ScheduleController extends Controller
{
    public function index(): Response
    {
        $this->authorize('courses.manage');
        return Inertia::render('Schedule', [
            'semesters' => Semester::orderBy('start_date', 'desc')->get(),
        ]);
    }
}
