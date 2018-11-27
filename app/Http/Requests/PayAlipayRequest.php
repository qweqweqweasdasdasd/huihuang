<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayAlipayRequest extends FormRequest
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
            'money'=>['required','min:1'],   //非负整数'regex:/^[1-9]\d*|0$/',
            'username'=>'required|between:2,12',
        ];
    }

    /**
     * 错误的信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'money.required'=>'金额必须存在的!',
            'money.min'=>'金额大于10元!',
            'username.required'=>'用户名必须存在!',
            'username.between'=>'用户名小于2大于12个字符!',
        ];
    }
}
