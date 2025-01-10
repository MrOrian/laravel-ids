<?php
namespace App\Repositories;

use App\Repositories\ProfileRepositoryInterface;
use App\Models\User;

class ProfileRepository implements ProfileRepositoryInterface{

    public function getProfile($user){
        return $user;
    }

    public function updateProfile($id, array $data){
        $user = User::findOrFail($id);
        $user->update($data);
        return $user->fresh();
    }

    public function deleteProfile($id){
        return User::destroy($id);
    }
}