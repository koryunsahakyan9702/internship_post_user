<?php
namespace App\Http\Contracts;
use App\Models\Comment;
use Ramsey\Collection\Collection;

interface CommentServiceInterface{
    public function postComment(int $id,array $data):string;
    public function subComment(int $id,int $commentId,array $data):string;
    public function update($id,$data):string;
    public function delete($id):string;
    public function likeComment($id);
}
