<?php

namespace App\Http\Repasitories;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;

class CommentRepository implements \App\Http\Contracts\CommentServiceInterface
{

    public function postComment( int $id,array $data):string
    {
        $user=Auth::user();
        $user->comments()->create([
            "title"=>$data["comment"],
            "post_id"=>$id,
        ]);
        return "You created a comment";
    }
    public function subComment(int $id,int $commentId,array $data): string
    {
        $user=Auth::user();
        $user->comments()->create([
            "title"=>$data["comment"],
            "post_id"=>$id,
            "parent_id"=>$commentId
        ]);
        return "You replied to a comment";
    }

    public function update($id, $data): string
    {
        $userid=Auth::user()["id"];
        $comment=Comment::query()->find($id);
        if($comment["user_id"]===$userid){
            $comment->update(["title"=>$data["comment"]]);
            return "The comment has been updated";
        }
        else {
            return "This is not your comment";
        }
    }

    public function delete($id):string
    {
        $comment=Comment::query()->find($id);
        if($comment["parent_id"]){
            $comment->delete();
            return "The comment has been deleted" ;
        }
        else {
            $com = Comment::query()->where(["parent_id" => $id])->delete();
            $comment->delete();
            return "The comment and replies have been deleted";
        }
    }

public function likeComment($id)
{
    $comment=Comment::query()->find($id);
    $userId=Auth::user()["id"];
    $like=Like::query()->where(["likeable_id"=>$id])->get();
    $hasLike=($comment->likes)->contains(function ($like) use ($userId){
        return $like->user_id===$userId;
    });
    if($hasLike){
        Like::query()->where(["user_id"=>$userId])->delete();
        return "Dislike";
    }
    else {
        $comment->likes()->create([
            "user_id"=>$userId
        ]);
        return "Like";
    }
}
}
