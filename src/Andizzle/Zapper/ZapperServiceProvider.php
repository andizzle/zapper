<?php

namespace Andizzle\Zapper;

use Illuminate\Support\ServiceProvider;
use Andizzle\Zapper\Console\RunCommand;


class ZapperServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('andizzle/zapper', 'andizzle/zapper');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        $this->registerCommands();

    }

    protected function registerCommands() {

        $commands = array('Run');

        foreach( $commands as $command ) {
            $this->{'register' . $command . 'Command'}();
        }

        $this->commands('zapper.run');

    }

    protected function registerRunCommand() {

        $this->app['zapper.run'] = $this->app->share(function($app) {
            return new RunCommand;
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}
?>
