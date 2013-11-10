<?php

namespace Andizzle\Zapper;

use \PHPUnit_TextUI_Command;
use Andizzle\Zapper\PHPUnitTestRunner;

class PHPUnitCommand extends PHPUnit_TextUI_Command {


    public static function main($exit = TRUE, $test = NULL) {

        $command = new PHPUnitCommand;
        return $command->run($_SERVER['argv'], $exit);

    }

    public function run(array $argv, $exit = TRUE, $test = NULL) {


        $argv = array();
        foreach($_SERVER['argv'] as $arg => $val) {

            if( array_key_exists($arg, $this->longOptions) )
                $argv[$arg] = $val;

        }

        parent::run($argv, $exit);

    }

    protected function createRunner() {

        return new PHPUnitTestRunner($this->arguments['loader']);

    }

}

?>
