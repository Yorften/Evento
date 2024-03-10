<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
        if($this->event->verified){
            return [
                'auto' => 'required',
            ];
        }
        return [
            'title' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'date' => 'required',
            'location' => 'required',
            'auto' => 'required',
            'category_id' => 'required',
        ];
    }
}
