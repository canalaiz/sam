<?php

/**
 * Canalaiz\Sam\SamServiceProvider.
 *
 * @link      https://github.com/canalaiz/sam
 *
 * @copyright 2016 Alessandro Canali
 */
namespace Canalaiz\Sam;

use Illuminate\Support\ServiceProvider;

class SamServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        // bind contracts to concrete implementation as default
        $this->app->bind('Canalaiz\Sam\Contracts\AssetRepository', 'Canalaiz\Sam\Repositories\ArrayAssetRepository');
        $this->app->bind('Canalaiz\Sam\Contracts\HtmlInjectEngine', 'Canalaiz\Sam\Infrastructure\RegexpHtmlInjectEngine');

        // declare facade singleton
        $this->app->singleton('sam', function ($app) {
            return $this->app->make('Canalaiz\Sam\Infrastructure\Sam');
        });
    }
}
