<?php
namespace App\Service;

use Log;
use Exception;
use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function createPost($user_id, $data) {
        $this->postRepository->create($user_id, $data);
    }

    public function editPost($postId, $data = []) {

    }

    public function deletePost($postId) {

    }

    public function getPost($postId) {
        $post = $this->postRepository->getPostById($postId);
        return $post;
    }


}

