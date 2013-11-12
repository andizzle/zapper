<?php

namespace Andizzle\Zapper;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


abstract class ZapperTestCase extends \Illuminate\Foundation\Testing\TestCase {

    protected $use_database = true;

    /**
     * Migrate & Seed the test DB
     */
    public function setUp() {

        parent::setUp();

        if( !$this->use_database )
            return;

        if( $this->test_db ) {

            Config::set('database.connections.' . DB::getName() . '.database', $this->test_db);
            DB::reconnect();

        }

    }

    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication() {

        $this->test_db = DB::getDatabaseName();
        $unitTesting = true;
        $testEnvironment = 'testing';

        return require base_path()  . '/bootstrap/start.php';

    }

}
?>
