<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * Railway (like Heroku, Fly and most PaaS load balancers) terminates TLS at
     * its edge and forwards plain HTTP to the container, marking the original
     * scheme in X-Forwarded-Proto. Its proxy has no fixed IP to allow-list, so
     * '*' is the documented configuration for that setup.
     *
     * Without this, Laravel ignores X-Forwarded-Proto, treats every request as
     * insecure, and asset()/url() emit http:// links on an https:// page -
     * which browsers then block as mixed content, loading the site with no CSS.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
