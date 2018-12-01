<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerTelLoginRequest extends FormRequest
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
            'mg_name'=>'required|between:2,12',
            'password'=>'required|between:2,12',
            'sms'=>'required|integer',
        ];
    }

    /**
     * 自定义错误信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'mg_name.required'=>'管理员名称必须存在!',
            'mg_name.between'=>'管理员名称大于2个小于12个字符!',
            'password.required'=>'密码必须存在!',
            'password.between'=>'密码大于2个字符小于12个字符!',
            'sms.required'=>'短信验证码必须存在!',
            'sms.integer'=>'短信验证码必须为数字!',
        ];
    }
}
