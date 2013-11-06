<?php

namespace Andizzle\Zapper\Console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Andizzle\Zapper\Console\ZapperCommand;

class DropDBCommand extends ZapperCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zapper:drop_db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop the test DB.';

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


    protected function dropDB() {

        if( $this->isVerbose() )
            $this->info(sprintf("Dropping test db %s ...", $this->test_db_name));

        try {

            DB::statement('DROP DATABASE ' . $this->test_db_name . ';');

        } catch(Exception $e) {

            $this->error($e->message);

        }

    }
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {

        $this->init( $this->option('db-name') );
        $this->dropDB();

    }

}
?>
