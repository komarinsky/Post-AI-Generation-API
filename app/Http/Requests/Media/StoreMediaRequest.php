<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['file', 'required', 'mimes:jpg,jpeg,png', 'max:5000'],
            'title' => ['string', 'required', 'max:256'],
            'description' => ['string', 'max:500'],
        ];
    }
}
