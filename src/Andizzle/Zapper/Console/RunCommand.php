<?php

namespace Andizzle\Zapper\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RunCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zapper:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run tests.';

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->default_db_type = Config::get('database.default');
        $this->default_db_name = Config::get('database.connections.' . $this->default_db_type . '.database');

    }


    protected function init( $db_name = NULL ) {

        $this->info("Initializing...");
        if( $db_name && $db_name != $this->default_db_name )
            $this->test_db_name = $db_name;
        else
            $this->test_db_name = $this->default_db_name . '_test_db';

    }


    protected function createDB() {

        $this->info(sprintf("Creating test database %s ...", $this->test_db_name));

        try {

            DB::statement('CREATE DATABASE IF NOT EXISTS ' . $this->test_db_name . ';');

        } catch(Exception $e) {

            $this->error($e->message);

        }

    }


    protected function dropDB() {

        $this->info(sprintf("Dropping test database %s ...", $this->test_db_name));

        try {

            DB::statement('DROP DATABASE ' . $this->test_db_name . ';');

        } catch(Exception $e) {

            $this->error($e->message);

        }

    }


    /**
     * Since we are creating test db on the fly, we need switch to the Test DB
     */
    protected function switchDB() {

        $this->info("Switching to test db ...");
        Config::set('database.connections.' . $this->default_db_type . '.database', $this->test_db_name);
        DB::reconnect();

    }


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


    protected function seed() {

        $this->call('db:seed');

    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {

        $this->init( $this->option('db-name') );
        $this->createDB();
        $this->switchDB();
        $this->migrate();
        $this->seed();

        if( !$this->option('no-drop') )
            $this->dropDB();

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array(
            array('db-name', null, InputOption::VALUE_OPTIONAL, 'Optional test DB name.', null),
            array('no-drop', null, InputOption::VALUE_OPTIONAL, 'Do not drop test DB after test.', null),
        );
    }

}
?>
