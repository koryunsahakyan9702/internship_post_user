<?php

namespace App\Http\Controllers;

use App\Http\Repasitories\Userrepository;
use App\Http\Repasitories\UserServiceRepasitory;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ramsey\Collection\Collection;

class UserController extends Controller
{
    protected $userrepository;
    public function __construct(Userrepository $userrepository){
        return $this->userrepository=$userrepository;
    }

    public function all():Collection{
        return $this->userrepository->allUser();
    }
    public function create(UserRequest $req){
        return $this->userrepository->createUser($req->validated());

    }
    public function login(LoginRequest $req){
        $validated=$req->validated();
        return $this->userrepository->loginUser($validated);
    }
    public function update(int $id,UserRequest $req):string{
        return $this->userrepository->updateUser($id,$req->validate());
    }
    public function destroy(int $id):string{
        return $this->userrepository->deleteUser($id);
    }

}
