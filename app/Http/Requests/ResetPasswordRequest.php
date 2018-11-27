<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'oldpassword'=>'required',
            'password'=>'required|confirmed|between:2,12'
        ];
    }

    /**
     * 报错信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'oldpassword.required'=>'旧密码必须输入!',
            'password.required'=>'新密码必须存在!',
            'password.confirmed'=>'新密码与确认密码不符!',
            'password.between'=>'密码大于2小于12个字符!'
        ];
    }
}
