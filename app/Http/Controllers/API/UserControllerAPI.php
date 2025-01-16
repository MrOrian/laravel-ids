<?php

namespace App\Http\Controllers\API;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\JsonService;
use App\Common\ErrorCode;
use App\Common\StatusCode;
class UserControllerAPI extends Controller{
    
    protected $userService;
    protected $jsonService;

    public function __construct(UserService $userService, JsonService $jsonService){
        $this->userService = $userService;
        $this->jsonService = $jsonService;
    }

    public function index(){
        return $this->jsonService->jsonResponse(
            StatusCode::OK,
            trans('msg.successful'),
            $this->userService->getHome()
        );
    }
    
    public function getAll(){
        return $this->jsonService->jsonResponse(
            StatusCode::OK,
            trans('msg.successful'),
            $this->userService->getAllUsersAPI()
        );
    }
    
    public function createUser(UserRequest $request){
        $data = $request->validated();
        if($this->userService->findEmail($data['email'])==null)
            return $this->jsonService->jsonResponse(
                StatusCode::OK,
                trans('msg.created'),
                $this->userService->createUserAPI($data)
            );
        
        return $this->jsonService->jsonResponse(
            StatusCode::BAD_REQUEST,
            trans('msg.user_existed'),
            $this->userService->findEmail($data['email'])
        );        
    }

    public function updateUser(UserRequest $request, $id){
        $data = $request->validated();
            
        if($this->userService->getUserById($id)!=null){
            return $this->jsonService->jsonResponse(
                StatusCode::OK,
                trans('msg.updated'),
                $this->userService->updateUserAPI($id, $data)
            );
        }

        return $this->jsonService->jsonResponse(
            StatusCode::BAD_REQUEST,
            trans('msg.user_not_found'),
            $this->userService->getUserById($id)
        );            
    }

    public function deleteUser($id){
        if($this->userService->getUserById($id)!=null)
            return $this->jsonService->jsonResponse(
                StatusCode::OK,
                trans('msg.deleted'),
                $this->userService->deleteUserAPI($id)
            );

        return $this->jsonService->jsonResponse(
            StatusCode::BAD_REQUEST,
            trans('msg.user_not_found'),
            $this->userService->getUserById($id)
        );
    }
}