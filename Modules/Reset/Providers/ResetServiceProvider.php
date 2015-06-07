<?php namespace Modules\Reset\Providers;

use Illuminate\Support\ServiceProvider;

class ResetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->app->bind('command.reset.data', 'Modules\Reset\Console\ResetDataCommand');

        $this->commands(['command.reset.data',]);
    }
}
