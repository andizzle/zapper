<?php

use Illuminate\Support\Facades\DB;

class BuildDBCommandTest extends PHPUnit_Framework_TestCase {

    public function testFire() {

        DB::shouldReceive('select')->once()->andReturn('foo');
        $cmd = $this->getMockBuilder('Andizzle\Zapper\Console\BuildDBCommand')
                    ->disableOriginalConstructor()
                    ->getMock();
        $cmd->fire();

    }

}

?>