<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Service\PostService;
use App\Traits\ResponseTrait;

class PostController extends Controller
{
    use ResponseTrait;
    protected $postService;

    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("posts");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        # 認證欄位
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse([
                "message" => $validator->errors()
            ]);
        }

        try {
            $createPost = $this->postService->createPost(Auth::id(), $request);
        } catch (\Throwable $th) {
            return $this->failResponse(null, $th->getMessage(), $th);
        }

        return $this->successResponse($createPost, "post created success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $post = $this->postService->getPost($id);
        // Log::info(json_encode($post));

        return response()->json([
            "code" => 0,
            "data" => $post,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        # 使用 vue spa 製作該服務，因此不需使用該 function
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId) {
        $user = Auth::user();

        // 判斷用戶是否有權限進行修改
        $updatePermission = $user->can("update", $this->postService->getPost($postId));
        if (!$updatePermission) {
            return $this->errorResponse(null, "You do not own this post.");
        }

        # 認證欄位
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse([
                "message" => $validator->errors()
            ]);
        }

        try {
            $updatePost = $this->postService->updatePost($postId, $request);
        } catch (\Throwable $th) {
            return $this->failResponse(null, $th->getMessage(), $th);
        }

        return $this->successResponse($updatePost, "post updated success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId)
    {
        $user = Auth::user();
        // 判斷用戶是否有權限進行刪除
        $deletePermission = $user->can("delete", $this->postService->getPost($postId));
        if (!$deletePermission) {
            return $this->errorResponse(null, "You do not own this post.");
        }

        try {
            $deletePost = $this->postService->deletePost($postId);
        } catch (\Throwable $th) {
            return $this->failResponse(null, $th->getMessage(), $th);
        }

        return $this->successResponse(null, "post deleted success");
    }

    # 取得文章列表
    public function posts(Request $request) {
        $page = $request->input("page", 0);

        $posts = $this->postService->getLatestPost($page);

        return $this->successResponse([
            "page" => $page,
            "data" => $posts
        ]);
    }

}
