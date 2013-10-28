<?php

namespace Andizzle\Zapper\Console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Andizzle\Zapper\Console\ZapperCommand;

class RunCommand extends ZapperCommand {

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

    private function __setEnv() {

        if( Config::get('zapper.mode') ) {
            $this->error('Environment variable "zapper.mode" is set before the test. Abandon the test.');
            die();
        }
        
        Config::set('zapper.mode', 'in-zapper');

    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {

        $this->init( $this->option('db-name') );
        $this->call('zapper:build_db');
        $this->call('zapper:migrate');
        $this->call('zapper:seed');

        $this->__setEnv();
        passthru('phpunit -d inbond=true');

        if( !$this->option('no-drop') && Config::get('zapper.mode') == 'in-zapper' )
            $this->call('zapper:drop_db');

    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array(
            array('db-name', null, InputOption::VALUE_OPTIONAL, 'Optional test DB name.', null),
            array('no-drop', null, InputOption::VALUE_NONE, 'Do not drop test DB after test.', null),
        );
    }

}
?>
