<?php

namespace App\Http\Controllers;

use App\Http\Repasitories\PostRepository;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postRepasitory;
    public function __construct(PostRepository $postRepasitory){
        $this->postRepasitory=$postRepasitory;
    }
    public function all():Collection{
        return $this->postRepasitory->getAll();

    }
public function create(PostRequest $req):Post{
    $user=Auth::user();
    $validated=$req->validated();
    return $this->postRepasitory->createPost($validated);
}
public function findById(int $id):Post{
        return $this->postRepasitory->findById($id);
}
public function updatePost(int $id,PostUpdateRequest $req):string{
        $validated=$req->validated();
        return $this->postRepasitory->update($id,$validated);
}
public function likePost($id):string{
        return $this->postRepasitory->like($id);
}
public function destroy(int $id):string
{
    return $this->postRepasitory->delete($id);
}
}
