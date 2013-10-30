<?php

namespace Andizzle\Zapper\Console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Andizzle\Zapper\Console\ZapperCommand;


class TruncateTableCommand extends ZapperCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zapper:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate certain tables.';

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


    protected function truncate( $table = null ) {

        if( is_string($table) )
            return DB::table($table)->delete();
        
        $tables = DB::getDoctrineSchemaManager()->listTableNames();

        foreach( $tables as $table ) {
            
            if( $this->isVerbose() )
                $this->info('Truncating ' . $table);
            DB::table($table)->delete();

        }

    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {

        $this->init( $this->option('db-name') );
        $this->switchDB();
        $this->truncate();

    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            array('table', InputArgument::OPTIONAL, 'Table name.', null)
        );
    }


}
?>
