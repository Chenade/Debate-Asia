<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articles;

class ArticlesController extends Controller
{
    //

    // update
    public function update(Request $request, $id)
    {
        // Update a specific article
        $article = Articles::where('article_id', $id)->first();
        if (!$article) {
            return response()->json(['success' => false, 'message' => 'Article not found.'], 404);
        }
        $article->update($request->all());
        return response()->json(['success' => true, 'data' => $article], 200);
    }
}
