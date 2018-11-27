<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'r_name'=>'required|between:2,12',
            'desc'=>'max:255',
        ];
    }

    /**
     * 错误信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'r_name.required'=>'用户名称必须存在!',
            'r_name.between'=>'用户名称大于2个字符小于12个字符!',
            'desc.max'=>'备注不得超出255个字符!',
        ];
    }
}
