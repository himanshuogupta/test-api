<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    public function hosts()
    {
        return [
            '^api\.yogeshdairy\.com$',
        ];
    }

    public function handle($request, \Closure $next)
    {
        \Log::info('Host Header Test', [
            'host' => $request->getHost(),
            'http_host' => $request->header('Host'),
        ]);

        return parent::handle($request, $next);
    }
}