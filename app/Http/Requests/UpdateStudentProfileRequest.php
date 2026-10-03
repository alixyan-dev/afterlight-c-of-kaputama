<?php

namespace App\Http\Requests;

use App\Models\StudentProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('students.manage') ?? false;
    }

    public function rules(): array
    {
        $profile = $this->route('student_profile');

        return [
            'npm' => [
                'required',
                'string',
                'max:20',
                Rule::unique('student_profiles', 'npm')->ignore($profile?->id ?? null, 'id'),
            ],
            'class_name' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
        ];
    }
}
