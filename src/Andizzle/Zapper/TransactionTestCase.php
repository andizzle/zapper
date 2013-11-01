<?php

namespace Andizzle\Zapper;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;


class TransactionTestCase extends \Illuminate\Foundation\Testing\TestCase {

    protected $useDatabase = true;
    protected $mode = null;

    /**
     * Migrate & Seed the test DB
     */
    public function setUp() {

        parent::setUp();

        $this->mode = in_array('inbond=true', $_SERVER['argv']);
        if( !$this->mode ) {
            Artisan::call("zapper:build_db", array(), new ConsoleOutput);
            Artisan::call("zapper:migrate", array(), new ConsoleOutput);
        }

    }

    /**
     * Destroy the test DB
     */
    public function tearDown() {

        parent::tearDown();

        if( !$this->mode )
            Artisan::call("zapper:drop_db", array(), new ConsoleOutput);

    }


    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication() {

        $unitTesting = true;
        $testEnvironment = 'testing';

        $six_level_up = '/../../../../../../';
        $twp_level_up = '/../../';
        if( file_exists(__DIR__ .  $six_level_up . 'bootstrap/start.php') )
            return require __DIR__ .  $six_level_up . 'bootstrap/start.php';

        return require __DIR__ . $two_level_up . 'bootstrap/start.php';

    }

}
?>
