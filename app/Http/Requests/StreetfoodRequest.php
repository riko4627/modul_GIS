<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class StreetfoodRequest extends FormRequest
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
        $rules = [
            'name_streetfoods' => 'required|max:50',
            'address_streetfoods' => 'required|max:50',
            'phone_streetfoods' => 'required|numeric|digits_between:10,12',
            'image_streetfoods' => $this->is('v1/streetfoods/update/*') ? 'image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',


        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name_streetfoods.required' => 'nama kedai wajib diisi',
            'name_streetfoods.max' => 'nama kedai tidak boleh lebih dari 50 karakter',

            'address_streetfoods.required' => 'alamat kedai wajib diisi',
            'address_streetfoods.max' => 'alamat kedai tidak boleh lebih dari 50 karakter',

            'phone_streetfoods.required' => 'Nomor telepon kedai wajib diisi.',
            'phone_streetfoods.numeric' => 'Nomor telepon harus berupa angka.',
            'phone_streetfoods.digits_between' => 'Nomor telepon harus antara 10-12 digit.',

            'image_streetfoods.required' => 'Gambar kedai wajib diunggah.',
            'image_streetfoods.image' => 'Gambar kedai harus berupa file gambar.',
            'image_streetfoods.mimes' => 'Gambar kedai harus berformat jpeg, png, atau jpg.',
            'image_streetfoods.max' => 'Ukuran gambar kedai tidak boleh lebih dari 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code' => 422,
            'message' => 'Check your validation',
            'errors' => $validator->errors()
        ]));
    }
}
