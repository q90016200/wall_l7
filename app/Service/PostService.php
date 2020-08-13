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

    public function createPost($user_id, $request) {
        $createPost = $this->postRepository->create($user_id, $request);
        if (!$createPost) {
            throw new Exception(__FUNCTION__." fail");
        }

        return $createPost;
    }

    public function editPost($postId, $request) {

    }

    public function deletePost($postId) {

    }

    public function getPost($postId) {
        $post = $this->postRepository->getPostById($postId);
        return $post;
    }


}

