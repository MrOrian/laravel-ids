<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Common\Constant;

class UserRepository implements UserRepositoryInterface
{
    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user->fresh();
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function searchByName($name)
    {
        return User::where('name', 'like', '%' . $name . '%');
    }

}
