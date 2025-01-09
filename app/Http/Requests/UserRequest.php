<?php

namespace App\Http\Requests; 

use App\Rules\ValidEmailExtension;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }

    public function rules() {
        // Quy tắc mặc định
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email,'.$this->route('user'), 
                new ValidEmailExtension(),
            ],
        ];

        // Nếu là phương thức POST (store), yêu cầu mật khẩu
        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|confirmed';
        }
    
        return $rules;
    }

    public function messages() {
        return [
            'name.required' => 'Tên không được để trống.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ];
    }
}
