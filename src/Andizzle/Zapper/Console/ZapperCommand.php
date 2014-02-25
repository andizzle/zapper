<?php

namespace Andizzle\Zapper\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ZapperCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = null;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = null;

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
        $this->default_db_type = DB::getName();
        $this->default_db_name = DB::getDatabaseName();

    }


    public function isVerbose() {
        return $this->output->getVerbosity() >= 2;
    }

    public function isVeryVerbose() {
        return $this->output->getVerbosity() >= 3;
    }

    public function isDebug() {
        return $this->output->getVerbosity() >= 4;
    }

    /**
     * Initialise db variables
     *
     * @return void
     */
    protected function init( $db_name = NULL ) {

        if( $db_name )
            $this->test_db_name = $db_name;
        else
            $this->test_db_name = $this->default_db_name . '_test_db';

    }

    /**
     * Since we are creating test db on the fly, we need switch to the Test DB
     */
    protected function switchDB() {


        if( $this->isVerbose() )
            $this->info(sprintf("Switching to %s ...", $this->test_db_name));

        Config::set('database.connections.' . $this->default_db_type . '.database', $this->test_db_name);
        DB::reconnect();

    }



    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array(
            array('db-name', null, InputOption::VALUE_OPTIONAL, 'Optional test DB name.', null),
        );
    }

}
?>
