<?php
namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    protected $postModel;

    // 透過 DI 注入 Model
    public function __construct(Post $post)
    {
        $this->postModel = $post;
    }

    // posts 新增紀錄
    public function create($user_id, $data) {
        $this->postModel::create([
            "author" => $user_id,
            "content" => $data["content"],
            "ip" => $data["ip"]
        ]);
    }
}
