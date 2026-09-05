<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
    public function hosts()
    {
        return [
            '^api\.yogeshdairy\.com$',
        ];
    }

    public function handle(Request $request, $next)
    {
        \Log::info('Host Header Test', [
            'host_header' => $request->headers->get('host'),
        ]);

        return parent::handle($request, $next);
    }
}