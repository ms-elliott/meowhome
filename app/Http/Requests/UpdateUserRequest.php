<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'password' => ['nullable', 'string', 'min:8', 'max:128', 'confirmed'],
            'name' => ['nullable', 'string', 'max:255'],
            // 'location_id' => ['required', 'numeric'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'image' => [
                'nullable',
                'file', // ファイルがアップロードされている
                'image', // 画像ファイルである
                'max:2000', // ファイル容量が2000kb以下である
                'mimes:jpeg,jpg,png', // 形式はjpegかpng
                'dimensions:min_width=100,min_height=100,max_width=1200,max_height=1200', // 画像の解像度
            ],
        ];
    }

    public function attributes()
    {
        return [
            'password_confirmation' => 'パスワード（確認）',
            'comment' => '自己紹介',
            'image' => 'プロフィール画像'
        ];
    }

    public function messages()
    {
        return [
            'image.dimensions' => '登録可能な画像サイズは縦横ともに:min_height〜:max_heightピクセルです。'
        ];
    }    
}
