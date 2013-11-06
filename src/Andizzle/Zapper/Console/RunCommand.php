<?php

namespace Andizzle\Zapper\Console;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Andizzle\Zapper\PHPUnitCommand;
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


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {

        $this->call("zapper:build_db", $this->getBuildDBArgs());
        $this->call("zapper:migrate", $this->getMigrateArgs());

        PHPUnitCommand::main(FALSE);

        if( !$this->option('no-drop') )
            $this->call("zapper:drop_db");

    }

    private function retrieveArgs($wanted, $offered) {

        foreach( $offered as $option => $value ) {
            if( array_key_exists('--' . $option, $wanted) )
                $wanted['--' . $option] = $value;
        }

        return $wanted;

    }

    private function getBuildDBArgs() {

        $options = array(
            '--db-name' => NULL
        );

        return $this->retrieveArgs($options, $this->option());

    }

    private function getMigrateArgs() {

        $options = array(
            '--db-name' => NULL,
            '--no-seed' => NULL
        );

        return $this->retrieveArgs($options, $this->option());

    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {

        $options = parent::getOptions();
        $_options = array(
            array('no-drop', null, InputOption::VALUE_NONE, 'Do not drop test DB after test.', null),
            array('no-seed', null, InputOption::VALUE_NONE, 'Indicates if the seed task should be re-run...', null)
        );
        return array_merge($_options, $options);

    }

}
?>
