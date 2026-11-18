<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Text;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JournalistController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();
        $myArticles = Text::with('category')
            ->where('user_id', Auth::id())
            ->latest('created_at')
            ->get();

        return view('journalist', compact('categories', 'myArticles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'heading' => ['required', 'string', 'max:255'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'text' => ['required', 'string'],
        ], [
            'heading.required' => 'Введите заголовок статьи',
            'categorie_id.required' => 'Выберите категорию',
            'categorie_id.exists' => 'Выбранная категория не найдена',
            'text.required' => 'Введите текст статьи',
        ]);

        Text::create([
            'heading' => $validated['heading'],
            'categorie_id' => $validated['categorie_id'],
            'text' => $validated['text'],
            'user_id' => Auth::id(),
            'is_blocked' => false,
        ]);

        return redirect()->route('journalist.index')->with('success', 'Статья успешно опубликована.');
    }

    public function edit(int $id): View
    {
        $article = Text::findOrFail($id);

        if ($article->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        return view('journalist-edit', compact('article', 'categories'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $article = Text::findOrFail($id);

        if ($article->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'heading' => ['required', 'string', 'max:255'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'text' => ['required', 'string'],
        ]);

        $article->update($validated);

        return redirect()->route('journalist.index')->with('success', 'Статья обновлена.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $article = Text::findOrFail($id);

        if ($article->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $article->delete();

        return redirect()->route('journalist.index')->with('success', 'Статья удалена.');
    }
}
