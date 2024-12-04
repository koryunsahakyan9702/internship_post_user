<?php
namespace App\Http\Contracts;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface UserServiceInterface{
    public function allUser():Collection;
    public function createUser(array $data);
    public function updateUser(int $id,array $data):string;
    public function deleteUser(int $id):string;
    public function loginUser( array $data):JsonResponse;
}
