<?php
namespace App\Http\Contracts;
use App\Models\Post;
use Illuminate\Support\Collection;

interface PostServiceInterface{
    public function getAll():Collection;
    public function createPost(array $data):Post;
    public function findById(int $id): ?Post;
    public function delete(int $id):string;
    public function update(int $id,array $data):string;
    public function like(int $id):string;
}
