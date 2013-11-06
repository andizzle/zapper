<?php

namespace Andizzle\Zapper;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;


class TransactionTestCase extends \Illuminate\Foundation\Testing\TestCase {

    protected $use_database = true;

    /**
     * Migrate & Seed the test DB
     */
    public function setUp() {

        parent::setUp();

        if( !$this->user_database )
            return;

        Artisan::call('zapper:truncate');

        if( !in_array('--no-seed', $_SERVER['argv']) )
            Artisan::call('db:seed');

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
