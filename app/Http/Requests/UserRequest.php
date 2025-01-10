<?php

namespace App\Http\Requests; 

use App\Rules\ValidEmailExtension;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    
    public function authorize() {
        return true;
    }

    public function rules() {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email,'.$this->route('user'), 
                new ValidEmailExtension(),
            ],
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|confirmed';
        }
    
        return $rules;
    }

    public function messages() {
        return trans('messages.checkUserRequest');
    }
    
}
