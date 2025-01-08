<?php

namespace App\Http\Request\UserRequest;

use App\Rules\ValidEmailExtension;

class UserRequest extends FormRequest{
    
    public function authorize(){
        return true;
    }

    public function rules(){
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->route('user'),
                new ValidEmailExtension(),
            ],
        ];

        if ($this->filled('password')) {
            $rules['password'] = 'required|string|confirmed';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ];
    }
}