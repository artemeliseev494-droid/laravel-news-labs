<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Text;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $articles = Text::with(['category', 'author'])
            ->where('is_blocked', false)
            ->latest('created_at')
            ->paginate(6);

        $categories = Category::withCount(['texts' => fn ($q) => $q->where('is_blocked', false)])->get();

        return view('index', compact('articles', 'categories'));
    }

    public function category(?int $id = null): View
    {
        $categories = Category::withCount(['texts' => fn ($q) => $q->where('is_blocked', false)])->get();

        $currentCategory = $id ? Category::findOrFail($id) : $categories->first();

        $articles = collect();
        if ($currentCategory) {
            $articles = Text::with(['category', 'author'])
                ->where('categorie_id', $currentCategory->id)
                ->where('is_blocked', false)
                ->latest('created_at')
                ->paginate(6);
        }

        return view('category', compact('articles', 'categories', 'currentCategory'));
    }

    public function show(int $id): View
    {
        $article = Text::with(['category', 'author'])->findOrFail($id);

        if ($article->is_blocked && (!auth()->check() || !auth()->user()->isAdmin())) {
            abort(404, 'Статья не найдена или заблокирована.');
        }

        return view('article', compact('article'));
    }
}
