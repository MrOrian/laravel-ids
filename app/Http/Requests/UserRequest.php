<?php

namespace App\Http\Requests; 

use App\Rules\ValidEmailExtension;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;
use App\Common\ErrorCode;
use App\Common\StatusCode;
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
        return trans('msg.checkUserRequest');
    }

    public function failedValidation(Validator $validator)
{
        Log::error('Validation failed: ', $validator->errors()->toArray());
        $msg = trans('msg.validation_failed');
        throw new CustomException(
            $msg,
            ErrorCode::FAILED,
            StatusCode::BAD_REQUEST,
        );
}
    
}
