<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('students.manage') ?? false;
    }

    public function rules(): array
    {
        $user = $this->route('student') ?? $this->route('user');
        $userId = is_string($user) ? $user : ($user?->id ?? null);

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId, 'id'),
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
