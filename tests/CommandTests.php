<?php

use Mockery as m;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Andizzle\Zapper\Console\BuildDBCommand;


class CommandsTestCase extends PHPUnit_Framework_TestCase {

    public function tearDown() {

        m::close();

    }


    public function setUp() {
        
        DB::shouldReceive('getName')->once()->andReturn('db');
        DB::shouldReceive('getDatabaseName')->once()->andReturn('db_name');
        DB::shouldReceive('select')->once()->andReturn(NULL);
        DB::shouldReceive('statement')->once()->andReturn(NULL);

    }


    public function testBuildDBCommand() {

        $cmd = new BuildDBCommand;
        $this->runCommand($cmd);

        $conn = $this->getConnection();

    }

    protected function getConnection() {
        return m::mock('Illuminate\Database\Connection');
    }

    protected function runCommand($command, $input = array()) {
        return $command->run(new Symfony\Component\Console\Input\ArrayInput($input), new Symfony\Component\Console\Output\NullOutput);
    }

}
?>