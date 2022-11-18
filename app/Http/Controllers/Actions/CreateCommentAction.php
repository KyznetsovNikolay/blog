<?php

namespace App\Http\Controllers\Actions;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateCommentAction
{
    public function __invoke(int $articleId, Request $request): JsonResponse
    {
            $data = $request->all();

            Comment::create([
                'author' => $data['author'],
                'text' => $data['text'],
                'article_id' => $articleId,
            ]);
            $comments = Comment::where(['article_id' => $articleId])->orderByDesc('id')->get();

            return response()->json($comments);
    }
}
