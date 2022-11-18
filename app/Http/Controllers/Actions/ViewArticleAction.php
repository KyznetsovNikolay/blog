<?php

namespace App\Http\Controllers\Actions;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ViewArticleAction
{
    public function __invoke(int $id, Request $request): Response
    {
        $article = Article::where('id', $id)->first();
        $comments = Comment::where('article_id', $id)->orderByDesc('id')->get();

        return new Response(view('article.view', [
            'article' => $article,
            'comments' => $comments,
        ]));
    }
}
