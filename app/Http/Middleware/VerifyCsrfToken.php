<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws TokenMismatchException
     */
    public function handle($request, Closure $next)
    {
        if ($this->isReading($request) || $this->tokensMatch($request) || $this->excludedRoutes($request))
        {
            return $this->addCookieToResponse($request, $next($request));
        }

        throw new TokenMismatchException;
    }

    protected function excludedRoutes($request)
    {
        $routes = [
            'externcall'
        ];

        foreach($routes as $route)
            if ($request->is($route))
                return true;

        return false;
    }

}
