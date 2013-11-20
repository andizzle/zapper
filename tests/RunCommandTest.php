<?php

use Illuminate\Support\Facades\DB;

class RunCommandTest extends PHPUnit_Framework_TestCase {

    public function testFire() {

        $cmd = $this->getMockBuilder('Andizzle\Zapper\Console\RunCommand')
                    ->disableOriginalConstructor()
                    ->getMock();
        $cmd->fire();

    }

}

?>