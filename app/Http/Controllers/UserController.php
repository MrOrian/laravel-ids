<?php

namespace App\Http\Controllers\UserController;

use App\Services\UserService;

class UserController extends Controller{
    protected $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    
}