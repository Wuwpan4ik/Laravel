<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:32',
            'comment' => 'required|max:256',
        ];
    }

    public function messages() {
        return [
            'title.required' => 'Поле заголовка является обязательным',
            'comment.required' => 'Поле комментария является обязательным',
        ];
    }
}
