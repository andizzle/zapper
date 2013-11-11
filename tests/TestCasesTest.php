<?php

use Andizzle\Zapper\PHPUnitTestSuite;
use Andizzle\Zapper\PHPUnitTestRunner;
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


    public function testExcuteSpecificTestCase() {

        $suite_one = $this->suiteFactory('PHPUnit_Framework_TestCase');
        $suite_two = $this->suiteFactory('PHPUnit_Framework_TestCase');

        $test_suite = new PHPUnit_Framework_TestSuite;
        $top_suite = new PHPUnit_Framework_TestSuite;
        $top_suite->setName('topSuite');
        $test_suite->setName('test_suite_one');
        $test_suite->addTest($suite_one);
        $test_suite->addTest($suite_two);
        $top_suite->addTestSuite($test_suite);

        $test_runner = new PHPUnitTestRunner;

        $test_suiteA = $test_suite;
        $test_suiteB = $test_suite;
        $test_suiteC = $test_suite;
        $top_suiteA = $top_suite;
        $top_suiteB = $top_suite;
        $top_suiteC = $top_suite;

        $test_runner->filterTests($test_suiteA, $suite_one->getName());
        $test_runner->filterTests($test_suiteB, $suite_two->getName());

        $tests = $suite_two->tests();
        $test = array_pop($tests);
        $test_runner->filterTests($test_suiteC, $suite_two->getName() . '.' . $test->getName());
        $test_runner->filterTests($top_suiteA, $top_suite->getName() . '.' . $test_suite->getName());
        $test_runner->filterTests($top_suiteB, $top_suite->getName() . '.' . $test_suite->getName() . '.' . $suite_two->getName());
        $tests = $suite_two->tests();
        $suite_two_test = array_pop($tests);
        $test_runner->filterTests($top_suiteC, $top_suite->getName() . '.' . $test_suite->getName() . '.' . $suite_two->getName() . '.' . $suite_two_test->getName());

        $this->assertEquals(count($test_suiteA->tests()), count($suite_one->tests()));
        $this->assertEquals(count($test_suiteB->tests()), count($suite_two->tests()));
        $this->assertTrue($test_suiteB instanceof PHPUnit_Framework_TestSuite);
        $this->assertTrue($test_suiteC instanceof PHPUnit_Framework_TestCase);

        $this->assertEquals(count($top_suiteA->tests()), 2);
        $this->assertEquals(count($top_suiteB->tests()), count($suite_two->tests()));
        $this->assertTrue($top_suiteC instanceof PHPUnit_Framework_TestCase);

    }

}

?>
