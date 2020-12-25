<?php 

namespace Eelcol\LaravelBlueprintGroup;

use Eelcol\LaravelBlueprintGroup\BaseServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Routing\Router;

class BlueprintGroupServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        Blueprint::macro('group', function($callback) {
            
            $group = new BlueprintGroup($this);
            call_user_func($callback, $group);

            return $group;
        });

    }
}
