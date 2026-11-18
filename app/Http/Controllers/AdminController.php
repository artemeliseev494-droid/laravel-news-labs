<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Role;
use App\Models\Text;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $articles = Text::with(['category', 'author'])->latest('created_at')->get();
        $users = User::with('role')->orderBy('id', 'asc')->get();
        $roles = Role::all();
        $categories = Category::all();

        return view('admin', compact('articles', 'users', 'roles', 'categories'));
    }

    public function toggleBlock(int $id): RedirectResponse
    {
        $article = Text::findOrFail($id);
        $article->is_blocked = !$article->is_blocked;
        $article->save();

        $status = $article->is_blocked ? 'заблокирована' : 'разблокирована';
        return redirect()->route('admin.index')->with('success', "Статья успешно {$status}.");
    }

    public function deleteArticle(int $id): RedirectResponse
    {
        $article = Text::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.index')->with('success', 'Статья удалена.');
    }

    public function editArticle(int $id): View
    {
        $article = Text::findOrFail($id);
        $categories = Category::all();

        return view('admin-edit-article', compact('article', 'categories'));
    }

    public function updateArticle(Request $request, int $id): RedirectResponse
    {
        $article = Text::findOrFail($id);

        $validated = $request->validate([
            'heading' => ['required', 'string', 'max:255'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'text' => ['required', 'string'],
        ]);

        $article->update($validated);

        return redirect()->route('admin.index')->with('success', 'Статья обновлена.');
    }

    public function updateUserRole(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->role_id = $validated['role_id'];
        $user->save();

        return redirect()->route('admin.index')->with('success', "Роль пользователя {$user->login} обновлена.");
    }
}
