<?php

namespace App\Http\Requests;

use App\Models\StudentProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('students.manage') ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'npm' => ['required', 'string', 'max:20', 'unique:student_profiles,npm'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
        ];
    }
}
