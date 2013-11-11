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


    /**
     * Filter test suites.
     * Format is '$testsuite.$testsuite.$testcase'
     */
    public function filterTests(&$suite, $test = NULL) {

        $test_suites = explode('.', trim($test, '.'));
        foreach($test_suites as $test_suite) {

            foreach($suite->tests() as $test) {

                $test_name = str_replace(' ', '_',  trim($test->getName()));
                if( $test_name == $test_suite )
                    $suite = $test;

            }

        }

    }


    /**
     * Filter the tests then sort them.
     * After that run the testsuite.
     */
    public function doRun(\PHPUnit_Framework_Test $suite, array $arguments = array()) {

        $test = isset($arguments['testcase']) && $arguments['testcase'] ? $arguments['testcase'] : NULL;
        $this->filterTests($suite, $test);
        $this->sortTests($suite);
        parent::doRun($suite, $arguments);

    }

}

?>
