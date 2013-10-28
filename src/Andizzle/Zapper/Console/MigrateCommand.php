<?php

namespace Andizzle\Zapper\Console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Andizzle\Zapper\Console\ZapperCommand;

class MigrateCommand extends ZapperCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zapper:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate schemas.';

    /**
     * System default db type
     */
    protected $default_db_type = NULL;


    /**
     * System default db config
     */
    protected $default_db_name = NULL;


    /**
     * System default db config
     */
    protected $test_db_name = NULL;



    /**
     * Migrate latest Db schema, also includes the schema in other packages
     */
    private function migrate() {

        $this->info("Migrate DB schemas ...");
        $this->call("migrate");

        $registered_namespaces = array_keys($this->laravel->app['config']->getNamespaces());
        foreach( $registered_namespaces as $namespace ) {

            $this->call('migrate', array('--package' => $namespace));

        }

    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {

        $this->init( $this->option('db-name') );
        $this->migrate();

    }

}
?>
