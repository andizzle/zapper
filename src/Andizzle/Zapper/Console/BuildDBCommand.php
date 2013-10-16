<?php

namespace Andizzle\Zapper\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BuildDBCommand extends Command {

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
    protected $description = 'Create and switch to test database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire() {
        //
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
        return array();
    }

}
?>
