<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('roles.assign') ?? false;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? $this->route('user');

        return [
            'role_name' => [
                'required',
                'string',
                Rule::in(Role::pluck('name')->toArray()),
            ],
            'user_id' => [
                'required',
                'string',
                Rule::exists(User::class, 'id'),
            ],
        ];
    }
}
