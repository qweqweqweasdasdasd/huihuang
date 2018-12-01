<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TjBudanRequest extends FormRequest
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
            'input_username'=>'required|max:20',
            'money'=>'required|numeric',
            'trade_no'=>'required|max:30',
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
            'input_username.required'=>'用户会员必须输入!',
            'input_username.max'=>'会员不到超出20个字符!',
            'money.required'=>'金额必须存在!',
            'money.numeric'=>'金额格式必须为数值!',
            'trade_no.required'=>'订单号必须存在!',
            'trade_no.max'=>'订单号长度不得大于30!'
            
        ];
    }
}
