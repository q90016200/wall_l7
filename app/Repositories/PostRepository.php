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

    // table posts 新增紀錄
    public function create($user_id, $request) {
        $this->postModel->user_id = $user_id;
        $this->postModel->content = $request->input("content");
        $this->postModel->ip = $request->getClientIp();

        if (!$this->postModel->save()) {
            return false;
        }

        return $this->postModel;
    }

    // 依照 posts table id 取得資料
    public function getPostById($postId) {
        return $this->postModel::where('id', $postId)->first();
    }

}
