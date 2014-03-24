<?php

namespace Ghunti\LaravelBase\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\MessageBag;
use Ghunti\LaravelBase\Validation\Validator;
use Ghunti\LaravelBase\Routing\Redirector;
use Session;

class LaravelBaseServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //Override Laravel Redirect
        $this->app->bindShared(
            'redirect',
            function ($app) {
                $redirector = new Redirector($app->url);

                // If the session is set on the application instance, we'll inject it into
                // the redirector instance. This allows the redirect responses to allow
                // for the quite convenient "with" methods that flash to the session.
                if (isset($app['session.store'])) {
                    $redirector->setSession($app['session.store']);
                }

                return $redirector;
            }
        );
    }

    public function boot()
    {
        //Extend the Validator
        $this->app->validator->resolver(
            function ($translator, $data, $rules, $messages) {
               return new Validator($translator, $data, $rules, $messages);
            }
        );

        //Bind messages from session to the view
        $this->registerMessagesWithView();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Same logic provided by ViewServiceProvider::registerSessionBinder to bind
     * the messages from session to the view.
     * If 'messages' exist in the session, a variable $messages will be inserted into the view.
     * If no 'messages' exist on the session an empty MessageBag is inserted
     */
    protected function registerMessagesWithView()
    {
        if ($messageBag = Session::get('messages')) {
            $this->app->view->share('messages', $messageBag);
        } else {
            $this->app->view->share('messages', new MessageBag);
        }
    }
}
