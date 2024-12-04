<?php

namespace App\Http\Repasitories;

use App\Http\Contracts\ind;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostRepository implements \App\Http\Contracts\PostServiceInterface
{

    public function getAll(): Collection
    {
        return Post::query()->with(["comments"=>function($query){
            $query->withCount('likes');
        },"comments.replies"=>function($query){
            $query->with("likes")->withCount("likes");
        },"likes"])->withCount("likes")->get();
    }

    public function createPost(array $data): Post
    {
        $user=Auth::user();
        return $user->posts()->create([
            "title"=>$data["title"]
        ]);
    }

    public function findById(int $id): ?Post
    {
        return Post::query()->find($id);
    }

    public function delete(int $id):string
    {
         $user=Auth::user();
         $post=Post::query()->find($id);
         if($post&&$post["user_id"]===$user["id"]){
             $post->delete();
             return "The post has been deleted";
         }
         else {
             return "This is not your post";
         }
    }

    public function update(int $id,array $data): string
    {
        $post=Post::query()->find($id);
        if($post&&$post["user_id"]===Auth::user()["id"]){
            $post->update([
                "title"=>$data["title"]
            ]);
            return "The post has been updated";
        }
        return "This is not your post";
    }

    public function like(int $id):string
    {
        $post=Post::query()->find($id);
        $userId=Auth::user()["id"];
        $like=Like::query()->where(["likeable_id"=>$id])->get();


        $hasLike= ($post->likes)->contains(function ($like) use ($userId){
            return $like->user_id===$userId;
        });
        if($hasLike){
            Like::query()->where(["user_id"=>$userId])->delete();
            return "Dislike";

        }
        else {
            $post->likes()->create([
                "user_id"=>$userId
            ]);
            return "like";
        }
    }
}
