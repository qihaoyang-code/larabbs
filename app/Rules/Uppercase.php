<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Uppercase implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     * passes 方法接收属性值和名称，并根据属性值是否符合规则而返回  true 或 false。
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        return strtoupper($value) === $value;
    }

    /**
     * Get the validation error message.
     * message 方法应返回验证失败时应使用的验证错误消息
     * @return string
     */
    public function message()
    {
//        return 'The :attribute must be uppercase.';
        return trans('validation.uppercase');
    }
}
