<?php

namespace Encore\SelectInlineCreate;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class SelectInlineCreateServiceProvider extends ServiceProvider
{
    protected $commands = [
      Console\PublishCommand::class
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.select-inline-create.bootstrap'  => Middleware\Bootstrap::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            'admin.select-inline-create.bootstrap',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function boot(SelectInlineCreate $extension)
    {
        if (! SelectInlineCreate::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'select-inline-create');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/select-inline-create')],
                'select-inline-create-assets'
            );
        }

        if($translations = $extension->translations()){
            $this->loadTranslationsFrom($translations, 'select-inline-create');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);

        $this->registerRouteMiddleware();
    }

    public function registerRouteMiddleware(){
        // register route middleware.
        /**
         * @var Router $router
         */
        $router = app('router');
        foreach ($this->routeMiddleware as $key => $middleware) {
            $router->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            $middlewareGroups = $router->getMiddlewareGroups();
            if(key_exists($key, $middlewareGroups)){
                $groupMiddleware = $middlewareGroups[$key];
                $middleware = array_merge($groupMiddleware, $middleware);
            }
            $router->middlewareGroup($key, $middleware);
        }
    }
}
