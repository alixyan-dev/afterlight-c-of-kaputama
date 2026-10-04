<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreMeetingRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('meetings.create') ?? false; }
    public function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'semester_id' => ['nullable', 'exists:semesters,id'],
            'session_number' => ['nullable', 'integer'],
            'title' => ['required', 'string', 'max:255'],
            'agenda' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'meeting_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'status' => ['nullable', 'string'],
        ];
    }
}
