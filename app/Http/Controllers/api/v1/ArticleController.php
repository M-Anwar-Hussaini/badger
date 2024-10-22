<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ArticleResource;
use App\Http\Resources\v1\ArticleCollection;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ArticleCollection(Article::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['max:50', 'required', Rule::unique('articles', 'title')],
            'body' => ['required', 'min:10']
        ]);
        $validatedData['slug'] = Str::slug($validatedData['title']);
        $validatedData['author_id'] = Auth::id() ?? 1;
        $article = Article::create($validatedData);
        return (new ArticleResource($article))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return (new ArticleResource($article))
            ->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => ['max:50', 'required', Rule::unique('articles')->ignore($article->id)],
            'body' => ['required', 'min:10']
        ]);
        $validatedData['slug'] = Str::slug($validatedData['title']);
        $validatedData['author_id'] = Auth::id() ?? 1;
        $article->update($validatedData);
        return (new ArticleResource($article))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->noContent();
    }

}
