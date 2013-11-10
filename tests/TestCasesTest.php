<?php

use Andizzle\Zapper\PHPUnitTestSuite;
use Andizzle\Zapper\TestCase;
use Andizzle\Zapper\TransactionTestCase;


class TestCasesTest extends PHPUnit_Framework_TestCase {

    private function populate() {

        $test_functions = array();
        $str = 'abcdefghijklmnopqrstuvwxyz';
        for( $i = 0; $i < rand(2, 5); $i ++ ) {
            $test_functions[] = 'test' . substr(md5(time() . str_shuffle($str) ), 0, 8);
        }
        return $test_functions;

    }

    private function suiteFactory($type) {

        $test_cases = $this->getMockBuilder($type)
                           ->setMethods($this->populate())
                           ->getMock();

        $suite = new PHPUnitTestSuite(new ReflectionClass($test_cases));

        return $suite;

    }

    public function testTestCasesOrdering() {

        $trans_suite = $this->suiteFactory('Andizzle\Zapper\TransactionTestCase');
        $testcase_suite = $this->suiteFactory('Andizzle\Zapper\TestCase');

        $test_suite = new PHPUnitTestSuite;
        $test_suite->addTest($trans_suite);
        $test_suite->addTest($testcase_suite);
        $tests = $test_suite->tests();

        for( $i = 0; $i < count($testcase_suite->tests()); $i ++ ) {

            $this->assertTrue($tests[$i] instanceof TestCase);

        }

        for( $j = $i; $j < count($trans_suite->tests()); $j ++ ) {

            $this->assertTrue($tests[$j] instanceof TransactionTestCase);

        }

    }

}

?>
