<?php
namespace App\Repositories;

interface ProfileRepositoryInterface {
    public function getProfile($user);
    public function updateProfile($id, array $data);
    public function deleteProfile($id);
} 