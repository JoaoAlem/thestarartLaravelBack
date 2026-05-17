<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Qualquer usuário pode fazer essa requisião
    }

    public function prepareForValidation(): void
    {
        $this->mergeIfMissing([
            'remember_token' => false,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', Rule::email()],
            'password' => ['required'],
            'remember_token' => ['sometimes', 'boolean'],
        ];
    }
}
