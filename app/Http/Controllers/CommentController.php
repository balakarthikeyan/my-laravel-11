<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function __construct(protected CommentService $postService)
    {
    }

    public function store(CommentRequest $request)
    {
        // $userId = Auth::id();
        $comment = $this->postService->create($request->validated());
        return response()->json(['comment' => $comment], 201);
    }
}