<?php

namespace Ghunti\LaravelBase\Http;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Contracts\MessageProviderInterface;
use Illuminate\Http\RedirectResponse as BaseRedirectResponse;

class RedirectResponse extends BaseRedirectResponse
{

    /**
     * Flash a container of errors to the session.
     *
     * @param  Illuminate\Support\Contracts\MessageProviderInterface|array  $provider
     * @return Ghunti\LaravelBase\Http\RedirectResponse
     */
    public function withMessages($provider)
    {
        if ($provider instanceof MessageProviderInterface) {
            $this->with('messages', $provider->getMessageBag());
        } else {
            $this->with('messages', new MessageBag((array) $provider));
        }

        return $this;
    }
}
