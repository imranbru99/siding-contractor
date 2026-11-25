<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeArticle;
use Illuminate\View\View;

class KnowledgeController extends Controller
{
    public function index(): View
    {
        $articles = KnowledgeArticle::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return view('site.knowledge.index', compact('articles'));
    }

    public function show(KnowledgeArticle $article): View
    {
        abort_unless($article->is_published, 404);

        return view('site.knowledge.show', compact('article'));
    }
}
