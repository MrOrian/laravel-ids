<?php
namespace App\Services;
use Illuminate\Support\Facades\Log;

use App\Repositories\UserRepositoryInterface;
use App\Common\Constant;
use App\Models\User;
use App\Exceptions\CustomException;
class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return User::paginate(Constant::PAGINATE_DEFAULT);;
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function create(array $data)
    {
        Log::info($data['name']);
        if(!isset($data['role_id'])){
            $data['role_id'] = 2;
        }
        Log::info('Data after role_id assigned:', ['role_id' => $data['role_id']]);
        return $this->userRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function searchByName($name){
        Log::info($name);
        return $this->userRepository->searchByName($name)->paginate(Constant::PAGINATE_DEFAULT);
    }
}
