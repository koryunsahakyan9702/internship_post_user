<?php

namespace App\Http\Repasitories;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Userrepository implements \App\Http\Contracts\UserServiceInterface
{

    public function allUser():\Illuminate\Support\Collection
    {
        return User::all();
    }

    public function createUser(array $data)
    {

        $user=User::query()->create([
            "name"=>$data["name"],
            "lastname"=>$data["lastname"],
            "email"=>$data["email"],
            "password"=>Hash::make($data["password"])
        ]);
        return $user;
    }

    public function updateUser(int $id, array $data):string
    {
        $userId=Auth::user()["id"];
        $user=User::query()->find($id);
        if($user&&$userId===$user["id"]){
                 $user->update([
                "name"=>$data["name"],
                "email"=>$data["email"],
                "lastname"=>$data["lastname"]
            ]);
                 return "updated";
        }
        return "There is no such user";
    }

    public function deleteUser(int $id):string
    {
        $user=User::query()->find($id)->delete();
        return "The user has been deleted";
    }
    public function loginUser( array $data):JsonResponse
    {
        $user=User::query()->where("email",$data["email"])->first();
        if($user&&Hash::check($data["password"],$user["password"])){
            $token=$user->createToken("user")->plainTextToken;
            return response()->json([
                "message"=>"ok",
                "token"=>$token
            ]);
        }
    }



}
