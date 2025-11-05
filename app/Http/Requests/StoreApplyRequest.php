<?php

namespace App\Http\Requests;

use App\Models\Apply;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreApplyRequest extends FormRequest
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
            'post_id' => ['required', 'numeric'],
            'user_id' => ['required', 'numeric'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            // post_idとuser_idの組み合わせが既に存在していないか確認
            $post_id = $this->input('post_id');
            $user_id = $this->input('user_id');
            $existsData = DB::table('applies')->where('post_id', $post_id)
                ->where('user_id', $user_id)
                ->whereNull('deleted_at')
                ->exists();

                if ($existsData) {
                    $validator->errors()->add('user_id', '既にこの募集に対して里親申請しているため、再度申請できません。');
                }

        });
    }
}
