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

        $options = array();
        if( $this->isVerbose() )
            $this->info("Migrate DB schemas ...");

        $registered_namespaces = array_keys($this->laravel->app['config']->getNamespaces());
        foreach( $registered_namespaces as $namespace ) {

            $this->call('migrate', array('--package' => $namespace));

        }

        if( !$this->option('no-seed') )
            $options = array('--seed' => true);

        $this->call("migrate", $options);

    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {

        $this->init( $this->option('db-name') );
        $this->switchDB();
        $this->migrate();

    }

    public function getOptions() {

        $options = parent::getOptions();
        $_options = array(
            array('no-seed', null, InputOption::VALUE_NONE, 'Indicates if the seed task should be re-run..', null)
        );
        return array_merge($_options, $options);

    }

}
?>
