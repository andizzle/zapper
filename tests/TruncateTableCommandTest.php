<?php

use Illuminate\Support\Facades\DB;

class TruncateTableCommandTest extends PHPUnit_Framework_TestCase {

    public function testFire() {

        $cmd = $this->getMockBuilder('Andizzle\Zapper\Console\TruncateTableCommand')
                    ->disableOriginalConstructor()
                    ->getMock();
        $cmd->fire();

    }

}

?>