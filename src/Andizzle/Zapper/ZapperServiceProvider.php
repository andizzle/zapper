<?php

namespace Andizzle\Zapper;

use Illuminate\Support\ServiceProvider;
use Andizzle\Zapper\Console\RunCommand;
use Andizzle\Zapper\Console\BuildDBCommand;
use Andizzle\Zapper\Console\DropDBCommand;
use Andizzle\Zapper\Console\TruncateTableCommand;
use Andizzle\Zapper\Console\MigrateCommand;


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

        $commands = array(
            'Run' => 'zapper.run',
            'BuildDB' => 'zapper.build_db',
            'DropDB' => 'zapper.drop_db',
            'Truncate' => 'zapper.truncate',
            'Migrate' => 'zapper.migrate'
        );

        foreach( array_keys($commands) as $command ) {
            $this->{'register' . $command . 'Command'}();
        }

        $this->commands(array_values($commands));

    }

    protected function registerRunCommand() {

        $this->app['zapper.run'] = $this->app->share(function($app) {
            return new RunCommand;
        });

    }

    protected function registerBuildDBCommand() {

        $this->app['zapper.build_db'] = $this->app->share(function($app) {
            return new BuildDBCommand;
        });

    }

    protected function registerDropDBCommand() {

        $this->app['zapper.drop_db'] = $this->app->share(function($app) {
            return new DropDBCommand;
        });

    }

    protected function registerTruncateCommand() {

        $this->app['zapper.truncate'] = $this->app->share(function($app) {
            return new TruncateTableCommand;
        });

    }

    protected function registerMigrateCommand() {

        $this->app['zapper.migrate'] = $this->app->share(function($app) {
            return new MigrateCommand;
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
