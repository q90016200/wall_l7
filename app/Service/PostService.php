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

    public function updatePost($postId, $request) {
        $updatePost = $this->postRepository->update($postId, $request);
        if (!$updatePost) {
            throw new Exception(__FUNCTION__." fail");
        }

        return $updatePost;
    }

    public function deletePost($postId) {
        $deletePost = $this->postRepository->delete($postId);
        if (!$deletePost) {
            throw new Exception(__FUNCTION__." fail");
        }
    }

    public function getPost($postId) {
        $post = $this->postRepository->getPostById($postId);
        return $post;
    }

    public function getLatestPost($page = 1) {
        $post = $this->postRepository->getLatestPost($page);
        return $post;
    }
}

