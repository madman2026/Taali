<?php

namespace Modules\Content\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Interaction\Services\InteractService;

class ViewContent
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $content = $request->route('Content');
        app(InteractService::class, [
            'interactable' => $content,
        ])->visit();

        return $next($request);
    }
}
