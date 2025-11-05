<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'user_id' => ['required', 'numeric'],
            'title' => ['required', 'max:255'],
            'body' => ['required', 'max:2000'],
            'status' => ['required', 'numeric'],
            'age_year' => ['required', 'numeric'],
            'age_month' => ['required', 'numeric', 'max:11'],
            'gender' => ['required', 'numeric'],
            'location_id' => ['required', 'numeric'],
            'breed_id' => ['nullable', 'numeric'],
            'pattern_id' => ['nullable', 'numeric'],
            'vaccined' => ['required', 'numeric'],
            'neutered' => ['required', 'numeric'],
            'accept_single' => ['required', 'numeric'],
            'accept_senior' => ['required', 'numeric'],
            'accept_location1' => ['nullable', 'numeric'],
            'accept_location2' => ['nullable', 'numeric'],
            'accept_location3' => ['nullable', 'numeric'],
            'accept_location4' => ['nullable', 'numeric'],
            'accept_location5' => ['nullable', 'numeric'],
            
            'photo1' => [
                'nullable',
                'file', // ファイルがアップロードされている
                'image', // 画像ファイルである
                'max:2000', // ファイル容量が2000kb以下である
                'mimes:jpeg,jpg,png', // 形式はjpegかpng
                'dimensions:min_width=100,min_height=100,max_width=1200,max_height=1200', // 画像の解像度
            ],
            'photo2' => [
                'nullable',
                'file', // ファイルがアップロードされている
                'image', // 画像ファイルである
                'max:2000', // ファイル容量が2000kb以下である
                'mimes:jpeg,jpg,png', // 形式はjpegかpng
                'dimensions:min_width=100,min_height=100,max_width=1200,max_height=1200', // 画像の解像度
            ],
            'photo3' => [
                'nullable',
                'file', // ファイルがアップロードされている
                'image', // 画像ファイルである
                'max:2000', // ファイル容量が2000kb以下である
                'mimes:jpeg,jpg,png', // 形式はjpegかpng
                'dimensions:min_width=100,min_height=100,max_width=1200,max_height=1200', // 画像の解像度
            ]
        ];
    }

    public function attributes()
    {
        return [
            'age_year' => '年齢：歳',
            'age_month' => '年齢：ヶ月',
            'vaccined' => 'ワクチン接種',
            'neutered' => '去勢/避妊手術',
            'breed_id' => '種類',
            'pattern_id' => '毛柄',
            'accept_single' => '単身者応募可',
            'accept_senior' => '高齢者応募可',            
            'accept_location1' => '応募可能地域１',
            'accept_location2' => '応募可能地域２',
            'accept_location3' => '応募可能地域３',
            'accept_location4' => '応募可能地域４',
            'accept_location5' => '応募可能地域５',
            'photo1' => '写真１',
            'photo2' => '写真２',
            'photo3' => '写真３',
        ];
    }    

    public function withValidator($validator)
    {
        // 地域に重複がないかチェック
        $location_id = $this->input('location_id');
        $accept_location1 = $this->input('accept_location1');
        $accept_location2 = $this->input('accept_location2');
        $accept_location3 = $this->input('accept_location3');
        $accept_location4 = $this->input('accept_location4');
        $accept_location5 = $this->input('accept_location5');
        
        $checked_values = [$location_id];
        $check_values = [$accept_location1, $accept_location2, $accept_location3, $accept_location4, $accept_location5];

        $validator->after(function ($validator) use($checked_values, $check_values)
        {
            for($i = 0; $i < 5; $i++){
                $check_value = $check_values[$i];
                if ($check_value != 0 && in_array($check_value, $checked_values)) {
                    $validator->errors()->add('accept_location' . $i + 1, '応募可能地域' . $i + 1 . 'が所在地または他の応募可能地域と重複しています。');
                }
                array_push($checked_values, $check_value);
            }
        });
    }
}
