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

    public function update($postId, $request) {
        $post = $this->postModel::where("id", $postId)->first();
        $post->content = $request->input("content");
        $post->ip = $request->getClientIp();

        if (!$post->save()) {
            return false;
        }

        return $post;
    }

    public function delete($postId) {
        $post = $this->postModel::where("id", $postId)->first();

        if (!$post->delete()) {
            return false;
        }
        return true;

    }

    public function getLatestPost($page = 1) {
        $posts = $this->postModel::with("writer")->orderBy("id", "desc")->simplePaginate(5);
        // $posts = $this->postModel::with("writer")->orderBy("id", "desc")->get();
        // $posts = Post::with(['writer' => function($q) {
        //     $q->select('id', 'name');
        // }])->get();

        // dd($posts);



        // foreach ($posts as $k => $post) {
        //     // dd($post->user());
        //     $post->user = $post->user()->first();
        //     unset($post->user->email);
        //     unset($post->user->email_verified_at);
        // }
        return $posts;
    }

}
