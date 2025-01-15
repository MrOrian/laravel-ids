<?php
namespace App\Services;

use App\Repositories\ProfileRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService {
    protected $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository) {
        $this->profileRepository = $profileRepository;
    }

    public function getProfile() {
        $user = Auth::user();
        return $this->profileRepository->getProfile($user);
    }

    public function updateProfile(array $data) {
        $user = Auth::user();

        // if (isset($data['current_password']) && !empty($data['current_password'])) {
        //     if (!Hash::check($data['current_password'], $user->password)) {
        //         return back()->withErrors(['current_password' => 'Mật khẩu cũ không đúng.']);
        //     }

        //     $data['password'] = Hash::make($data['new_password']);
        // } 
        // Chưa cần dùng
        
        if (isset($data['avatar']) && $data['avatar']->isValid()) {
            $avatarPath = $data['avatar']->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }
        else {
            $avatar = 'avatars/default_avatar.png'; 
        }

        return $this->profileRepository->updateProfile($user->id, $data);
    }

    public function deleteProfile() {
        $user = Auth::user();
        return $this->profileRepository->deleteProfile($user->id);
    }
}
