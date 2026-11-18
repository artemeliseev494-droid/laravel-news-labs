<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Для доступа к этому разделу необходимо войти в систему.');
        }

        $user = Auth::user();

        if ($user->isAdmin() || $user->hasRole(...$roles)) {
            return $next($request);
        }

        abort(403, 'У вас недостаточно прав для просмотра этой страницы.');
    }
}
