<?php

namespace App\Http\Requests;

use Attribute;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:128', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:18'],
            'location_id' => ['required', 'integer'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'image' => [
                'nullable',
                'file', // ファイルがアップロードされている
                'image', // 画像ファイルである
                'max:2000', // ファイル容量が2000kb以下である
                'mimes:jpeg,jpg,png', // 形式はjpegかpng
                'dimensions:min_width=100,min_height=100,max_width=1200,max_height=1200', // 画像の解像度が100px * 100px ~ 300px * 300px
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
            'age.min' => ':min歳未満の方はご利用いただけません。',
            'image.dimensions' => '登録可能な画像サイズは縦横ともに:min_height〜:max_heightピクセルです。'
        ];
    }
}
