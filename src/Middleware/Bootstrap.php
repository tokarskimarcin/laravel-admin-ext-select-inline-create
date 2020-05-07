<?php


namespace Encore\SelectInlineCreate\Middleware;

use Closure;
use Illuminate\Http\Request;

class Bootstrap
{
    public function handle(Request $request, Closure $next)
    {
        //bootstraping
        require $this->getBootstrapPath();

        return $next($request);
    }

    /**
     * @return string
     */
    protected function getBootstrapPath(){
        return __DIR__.'/../bootstrap.php';
    }
}
