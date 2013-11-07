<?php

namespace Andizzle\Zapper;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;


class TestCase extends \Illuminate\Foundation\Testing\TestCase {

    protected $use_database = true;
    protected $pdo = null;

    /**
     * Migrate & Seed the test DB
     */
    public function setUp() {

        parent::setUp();

        if( !$this->use_database )
            return;

        $this->pdo = DB::connection()->getPdo();
        $this->pdo->beginTransaction();

    }

    /**
     * Destroy the test DB
     */
    public function tearDown() {

        parent::tearDown();

        if( !$this->user_database )
            return;

        $this->pdo->rollBack();

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
