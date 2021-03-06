<?php

/*
 * This file is part of the codicastudio/nova-activitylog
 *
 * (c) Bole Chen <avenger@php.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Bolechen\NovaActivitylog\Http\Middleware;

use Bolechen\NovaActivitylog\NovaActivitylog;
use Laravel\Nova\Nova;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        $tool = collect(Nova::registeredTools())->first([$this, 'matchesTool']);

        return optional($tool)->authorize($request) ? $next($request) : abort(403);
    }

    /**
     * Determine whether this tool belongs to the package.
     *
     * @param \Laravel\Nova\Tool $tool
     *
     * @return bool
     */
    public function matchesTool($tool)
    {
        return $tool instanceof NovaActivitylog;
    }
}
