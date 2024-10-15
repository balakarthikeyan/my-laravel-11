<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    public function create(array $data)
    {
        return Comment::create([
            'description' => $data['description'],
        ]);
    }
}