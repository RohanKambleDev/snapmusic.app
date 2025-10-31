<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by auth middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:10240', // 10MB in kilobytes
            ],
            'audio' => [
                'required',
                'file',
                'mimes:mp3,wav',
                'max:10240', // 10MB in kilobytes
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'image.required' => 'Please upload an image file.',
            'image.mimes' => 'The image must be a JPG or PNG file.',
            'image.max' => 'The image file size must not exceed 10MB.',
            'audio.required' => 'Please upload an audio file.',
            'audio.mimes' => 'The audio must be an MP3 or WAV file.',
            'audio.max' => 'The audio file size must not exceed 10MB.',
        ];
    }
}
