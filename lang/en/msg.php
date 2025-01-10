<?php

return [
    'created' => 'User Created Successfully!',
    'updated' => 'User Updated Successfully!',
    'update_failed' => 'User Updated Successfully!',
    'deleted' => 'User Deleted Successfully!',
    'checkUserRequest' => [
        'name.required' => 'Tên không được để trống.',
        'name.max' => 'Tên không được vượt quá 255 ký tự.',
        'email.required' => 'Email không được để trống.',
        'email.email' => 'Địa chỉ email không hợp lệ.',
        'email.unique' => 'Email này đã được đăng ký.',
        'password.required' => 'Mật khẩu không được để trống.',
        'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
    ],
];