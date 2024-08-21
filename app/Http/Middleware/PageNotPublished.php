<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class PageNotPublished
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next):Response
    {
        if (!$request->page->isPublished() && $request->user()->id !== $request->page->user_id) {
            return redirect()->route('pages.not.published');
        }

        return $next($request);
    }
}
