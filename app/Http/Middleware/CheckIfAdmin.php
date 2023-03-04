<?php


namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\App;
class CheckIfAdmin
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (!isset($user)) {
            return redirect(route('login'));
        }

        if (!$user->isAdmin()) {
            return redirect(route('login'));
        }
        App::setLocale('ru');

        return $next($request);
    }
}
