<?php

namespace App\Http\Requests;

use App\Models\Organizer;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required',
            'company' => 'required',
            'company_email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Organizer::class],
            'website' => ['required', 'regex:/^(?:https?:\/\/)?(?:www\.)?\w*\.\w{2,4}$/i'],
            'type' => 'required',
        ];
    }
}
