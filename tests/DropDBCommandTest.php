<?php

use Illuminate\Support\Facades\DB;

class DropDBCommandTest extends PHPUnit_Framework_TestCase {

    public function testFire() {

        DB::shouldReceive('statement')->once()->andReturn('foo');
        $cmd = $this->getMockBuilder('Andizzle\Zapper\Console\DropDBCommand')
                    ->disableOriginalConstructor()
                    ->getMock();
        $cmd->fire();

    }

}

?>