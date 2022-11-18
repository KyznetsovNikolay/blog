<?php

namespace App\Http\Controllers\Actions;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexArticleAction
{
    public function __invoke(Request $request)
    {
        $categories = Category::all();
        $articlesQuery = Article::query();

        if ($request->ajax()) {
            $requestData = $request->all();

            if (isset($requestData['search'])) {
                $articlesQuery = $articlesQuery->where('title', $requestData['search']);
            }

            if (isset($requestData['fromDate'])) {
                $articlesQuery = $articlesQuery->where('created_at', new \DateTime($requestData['fromDate']));
            }

            if (isset($requestData['category']) && $requestData['category'] != 0) {
                $articlesQuery = $articlesQuery->where('category_id', $requestData['category']);
            }

            $articles = $articlesQuery->get();

            return response()->json([
                'articles' => $articles,
                'categories' => $categories,
            ]);
        }

        return new Response(view('article.index', [
            'articles' => $articlesQuery->get(),
            'categories' => $categories,
        ]));
    }
}
