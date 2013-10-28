<?php

namespace Andizzle\Zapper\Console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Andizzle\Zapper\Console\ZapperCommand;


class SeedCommand extends ZapperCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zapper:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding the test DB.';

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
        $this->switchDB();
        $this->seed();

    }

}
?>
