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
                'max:2048', // 2MB in kilobytes to match system php.ini
            ],
            'audio' => [
                'required',
                'file',
                'mimes:mp3,wav',
                'max:2048', // 2MB in kilobytes to match system php.ini
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
            'image.max' => 'The image file size must not exceed 2MB.',
            'audio.required' => 'Please upload an audio file.',
            'audio.mimes' => 'The audio must be an MP3 or WAV file.',
            'audio.max' => 'The audio file size must not exceed 2MB.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $files = ['image', 'audio'];

            foreach ($files as $field) {
                $file = $this->file($field);

                if ($file && !$file->isValid()) {
                    \Illuminate\Support\Facades\Log::channel('snapmusic')->error("UPLOAD_FAIL: PHP Upload Error for {$field}", [
                        'user_id' => auth()->id(),
                        'field' => $field,
                        'error_code' => $file->getError(),
                        'error_message' => $file->getErrorMessage(),
                    ]);
                }
            }
        });
    }
}
