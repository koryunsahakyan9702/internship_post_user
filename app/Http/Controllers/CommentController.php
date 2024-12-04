<?php

namespace App\Http\Controllers;

use App\Http\Repasitories\CommentRepository;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentRepasitory;
    public function __construct(CommentRepository $commentRepasitory)
    {
        return $this->commentRepasitory=$commentRepasitory;
    }

    public function writeComment(int $id,CommentRequest $req,):string{
        $validated=$req->validated();
        return $this->commentRepasitory->postComment($id,$validated,);

    }
    public function replyComment(int $id,int $commentId,CommentRequest $req):string{
      return $this->commentRepasitory->subComment($id,$commentId,$req->validated());
    }
    public function destroyComment($id):string{
        return $this->commentRepasitory->delete($id);
    }
    public function updateComment(int $id,CommentRequest $req):string{
        return $this->commentRepasitory->update($id,$req->validated());

    }
    public function likeComment( $id){
        return $this->commentRepasitory->likeComment($id);
    }

}
