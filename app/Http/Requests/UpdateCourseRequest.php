<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('courses.manage') ?? false;
    }

    public function rules(): array
    {
        /** @var Course $course */
        $course = $this->route('course');

        return [
            'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($course)],
            'name' => ['required', 'string', 'max:255'],
            'lecturer_name' => ['required', 'string', 'max:255'],
            'day_of_week' => ['required', 'string', 'max:20'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'room' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
            'semester_id' => ['nullable', 'exists:semesters,id'],
        ];
    }
}
