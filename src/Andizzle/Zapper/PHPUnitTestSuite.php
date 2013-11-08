<?php

namespace Andizzle\Zapper;

use \PHPUnit_Framework_TestSuite;


class PHPUnitTestSuite extends PHPUnit_Framework_TestSuite {

    protected $testCase = array();
    protected $transactionCase = array();
    protected $otherCase = array();


    private function isTestCase($testCase) {
        return is_subclass_of( $testCase, "Andizzle\Zapper\TestCase" );
    }

    private function isTransactionTestCase($testCase) {
        return is_subclass_of( $testCase, "Andizzle\Zapper\TransactionTestCase" );
    }

    private function hasTestCase($testSuite) {
        return !empty($testSuite->tests);
    }

    public function sortTest(&$testSuite) {

        //if is a test suite, sort its test cases
        if( !$testSuite instanceof PHPUnit_Framework_TestSuite )
            return;


        if( !$testSuite->testCase ) {

            foreach( $testSuite->tests as $test ) {
                $this->sortTest($test);
            }

        } else {

            if( !$this->hasTestCase($testSuite) )
                return;

            $testCase = $testSuite->tests[0];

            if( $this->isTestCase($testCase) )
                $this->testCase[] = $testSuite;
            elseif( $this->isTransactionTestCase($testCase) )
                $this->transactionCase[] = $testSuite;
            else
                $this->otherCase[] = $testSuite;

        }

    }

    public function sortGroupTests(&$group) {

        if( is_array($group) ) {

            foreach( $group as $g ) {
                $this->sortGroupTests($g);
            }

        } elseif ( $group instanceof PHPUnit_Framework_TestSuite ) {

            $this->sortTest($group);

        }

    }

    public function sort($testsuite = NULL) {

        $tests = array();
        if( !$testsuite )
            $testsuite = $this;

        foreach( $testsuite->tests as $test ) {

            if( $test instanceof PHPUnit_Framework_TestSuite )
                $tests = array($tests, $this->sort($test));
            else
                $tests[] = $test;

        }

        return $tests;

    }

    public function addTest(\PHPUnit_Framework_Test $test, $groups = array()) {

        parent::addTest($test, $groups);
        $this->tests = $this->sort();

    }

}

?>
