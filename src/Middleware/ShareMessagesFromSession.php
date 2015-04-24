<?php

namespace Ghunti\LaravelBase\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Support\MessageBag;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ShareMessagesFromSession implements Middleware
{
    /* Create a new error binder instance.
     *
     * @param  \Illuminate\Contracts\View\Factory  $view
     * @return void
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    /**
     * Same logic provided by Illuminate\View\Middleware::ShareErrorsFromSession to bind
     * the messages from session to the view.
     * If 'messages' exist in the session, a variable $messages will be inserted into the view.
     * If no 'messages' exist on the session an empty MessageBag is inserted
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('messages')) {
            $this->view->share('messages', $request->session()->get('messages'));
        } else {
            $this->view->share('messages', new MessageBag);
        }
        return $next($request);
    }
}
