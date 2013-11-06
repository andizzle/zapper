<?php

namespace Andizzle\Zapper\Console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Andizzle\Zapper\Console\ZapperCommand;


class BuildDBCommand extends ZapperCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zapper:build_db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test DB.';

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
     * Prepare the database manipulation
     */
    protected function prepare() {

        $existing_db = DB::select(SPRINTF("SHOW DATABASES LIKE '%s'", $this->test_db_name));
        if( !count($existing_db) )
            return;

        if( $this->confirm(sprintf('A database named %s already exists, do you wish to drop it and continue the test? [yes|no]: ', $this->test_db_name)) )
            DB::statement(sprintf('DROP DATABASE %s', $this->test_db_name));
        else
            die("Test terminated.\n");

        return;

    }


    /**
     * Create the database
     */
    protected function createDB() {

        if( $this->isVerbose() )
            $this->info(sprintf("Creating test db %s ...", $this->test_db_name));

        try {

            DB::statement('CREATE DATABASE IF NOT EXISTS ' . $this->test_db_name . ';');

        } catch(Exception $e) {

            echo $this->error($e->message);

        }

    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {

        $this->init( $this->option('db-name') );
        $this->prepare();
        $this->createDB();

    }


}
?>
