<?php

use Illuminate\Support\Facades\DB;

class MigrateDBCommandTest extends PHPUnit_Framework_TestCase {

    public function testFire() {

        DB::shouldReceive('statement')->once()->andReturn('foo');
        $cmd = $this->getMockBuilder('Andizzle\Zapper\Console\MigrateCommand')
                    ->disableOriginalConstructor()
                    ->getMock();
        $cmd->fire();

    }

}

?>