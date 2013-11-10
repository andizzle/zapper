<?php

namespace Andizzle\Zapper;

use \PHPUnit_Framework_TestSuite;


class PHPUnitTestSuite extends PHPUnit_Framework_TestSuite {

    /**
     * Sort test cases.
     * The desired order is TestCases, TransactionTestCases then other cases.
     */
    public function sort() {

        $testcases = array();
        $trans_testcases = array();
        $other_testcases = array();

        $cases = $this->getTestCases();
        foreach( $cases as $case ) {
            if( $case instanceof TestCase )
                $testcases[] = $case;
            elseif( $case instanceof TransactionTestCase )
                $trans_testcases[] = $case;
            else
                $other_testcases[] = $case;
        }

        $this->tests = array_merge($testcases, $trans_testcases, $other_testcases);

    }


    /**
     * Retrieve all test cases from each test suite.
     */
    public function getTestCases(&$testcases = array(), $suite = null) {

        if( $suite == null ) {
            $this->getTestCases($testcases, $this);
        } else {
            foreach( $suite->tests() as $test ) {

                if( $test instanceof PHPUnit_Framework_TestSuite )
                    $this->getTestCases($testcases, $test);
                else
                    $testcases[] = $test;

            }
        }

        return $testcases;

    }


    /*
     * Add test with orderring.
     */
    public function addTest(\PHPUnit_Framework_Test $test, $groups = array()) {

        parent::addTest($test, $groups);
        $this->sort();

    }

}

?>
