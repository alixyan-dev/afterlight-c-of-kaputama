<?php
namespace App\Http\Requests;
use App\Models\Meeting;
use Illuminate\Foundation\Http\FormRequest;
class UpdateMeetingRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('meetings.update') ?? false; }
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
            'status' => ['nullable', 'string', 'in:draft,submitted,validated,rejected,cancelled'],
        ];
    }
}
