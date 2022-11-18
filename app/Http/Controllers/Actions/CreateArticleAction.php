<?php

namespace App\Http\Controllers\Actions;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateArticleAction
{
    public function __invoke(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $errMessage = 'Данные заполнены не до конца';

            if (is_null($data['title']) || is_null($data['author']) || is_null($data['text']) || is_null($data['category'])) {
                throw new \Exception($errMessage);
            }

            try {
                Article::create([
                    'title' => $data['title'],
                    'author' => $data['author'],
                    'text' => $data['text'],
                    'category_id' => $data['category'],
                ]);
            } catch (\Exception $e) {
                throw new \Exception($errMessage);
            }

            return response()->json([sprintf('Статья %s была успешно создана', $data['title'])]);
        }

        $categories = Category::all();
        return new Response(view('article.create', ['categories' => $categories]));
    }
}
