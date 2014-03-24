<?php

namespace Ghunti\LaravelBase\Routing;

use Illuminate\Routing\Redirector as BaseRedirector;
use Ghunti\LaravelBase\Http\RedirectResponse;

class Redirector extends BaseRedirector
{

    /**
     * Create a new redirect response.
     *
     * @param  string  $path
     * @param  int     $status
     * @param  array   $headers
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function createRedirect($path, $status, $headers)
    {
        $redirect = new RedirectResponse($path, $status, $headers);

        if (isset($this->session)) {
            $redirect->setSession($this->session);
        }

        $redirect->setRequest($this->generator->getRequest());

        return $redirect;
    }
}
