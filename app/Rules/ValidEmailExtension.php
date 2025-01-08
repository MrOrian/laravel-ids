<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEmailExtension implements Rule
{
    /**
     * Xác thực giá trị của email.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Kiểm tra phần mở rộng email
        return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|net|org|edu)$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email phải có phần mở rộng hợp lệ như .com, .net, .org, .edu.';
    }
}
