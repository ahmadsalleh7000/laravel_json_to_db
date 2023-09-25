<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JsonUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'json_file' => 'required|file|mimes:json|max:2048', // Adjust the validation rules as needed
        ];
    }

    public function messages()
    {
        return [
            'json_file.required' => 'The JSON file is required.',
            'json_file.mimes'    => 'The file must be a JSON file.',
            'json_file.max'      => 'The file may not be greater than 2048 kilobytes.',
        ];
    }
}
