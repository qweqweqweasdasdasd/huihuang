<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
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
            'ps_name'=>'required|max:100',
            'ps_pid'=>'required|integer',
            'ps_c'=>'required|max:150|alpha',
            'ps_a'=>'required|max:150|alpha',
            'ps_route'=>['required','max:150','regex:/^\/(.*)\/(.*)$/'],
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
            'ps_name.required'=>'权限的名称必须存在!',
            'ps_name.max'=>'权限的名称不得大于100个字符!',
            'ps_pid.required'=>'父级权限必须存在!',
            'ps_pid.integer'=>'父级权限格式不对!',
            'ps_c.required'=>'控制器必须存在!',
            'ps_c.max'=>'控制器不得大于150个字符!',
            'ps_c.alpha'=>'控制器只能为英文!',
            'ps_a.required'=>'方法必须存在!',
            'ps_a.max'=>'方法不得大于150个字符!',
            'ps_a.alpha'=>'方法只能为英文!',
            'ps_route.required'=>'路由必须存在!',
            'ps_route.max'=>'路由不得大于150个字符!',
            'ps_route.regex'=>'路由格式应为/####/####',
            'desc.max'=>'描述不得大于255个字符!',
        ];
    }
}
