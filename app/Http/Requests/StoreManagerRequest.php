<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagerRequest extends FormRequest
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
            'password'=>'required|between:2,12|confirmed',
            'status'=>'required|integer',
            'r_id'=>'required|integer',
            'desc'=>'max:255',
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
            'mg_name.required'=>'管理员名称必须存在!',
            'mg_name.between'=>'管理员大于2小于12个字符!',
            'password.required'=>'密码必须存在!',
            'password.between'=>'密码必须大于4个小于12个字符',
            'password.confirmed'=>'原始密码和确认密码不对!',
            'status.required'=>'状态必须存在!',
            'status.integer'=>'状态的格式不对!',
            'r_id.required'=>'角色必须存在!',
            'r_id.integer'=>'角色格式不对!',
            'desc.max'=>'备注不得大于255个字符!',
        ];
    }

}
