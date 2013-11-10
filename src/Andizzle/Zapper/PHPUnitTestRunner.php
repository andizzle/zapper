<?php

namespace Andizzle\Zapper;

use \PHPUnit_TextUI_TestRunner;
use \PHPUnit_Framework_Test;


class PHPUnitTestRunner extends PHPUnit_TextUI_TestRunner {

    /**
     * Sorting the suit cases
     */
    public function sortTests(&$suite) {

        if( !$suite instanceof \PHPUnit_Framework_TestSuite )
            return;

        $tests = $suite->tests();
        $test_suite = new PHPUnitTestSuite;
        $test_suite->addTestSuite($suite);
        $suite = $test_suite;

    }

    public function doRun(\PHPUnit_Framework_Test $suite, array $arguments = array()) {

        $this->sortTests($suite);
        parent::doRun($suite, $arguments);

    }

}

?>
