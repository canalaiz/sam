<?php

/**
 * Canalaiz\Sam\Middleware\Sam
 *
 * @link      https://github.com/canalaiz/sam
 * @copyright 2016 Alessandro Canali
 */

namespace Canalaiz\Sam\Middleware;

use Closure;

class Sam {

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $response = $next($request);

        $html = \Canalaiz\Sam\Facades\Sam::process($response->getOriginalContent());

        $response->setContent($html);
        return $response;
    }

}
