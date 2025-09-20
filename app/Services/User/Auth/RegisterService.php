<?php
// app/Services/Auth/RegisterService.php

namespace App\Services\User\Auth;

use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function __construct(protected FileUploadService $fileUploadService){}

    public function create(array $data): User
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        if (isset($data['image'])) {
            $userData['image'] = $this->fileUploadService->uploadImage(
                $data['image'], 
                'users', 
                300, 
                300
            );
        }

        return User::create($userData);
    }
}