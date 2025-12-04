<?php

namespace iboxs\swoole\middleware;

use Closure;
use iboxs\Request;
use iboxs\Response;

/**
 * @deprecated 废弃 改用 topthink/iboxs-dumper
 */
class InteractsWithVarDumper
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
