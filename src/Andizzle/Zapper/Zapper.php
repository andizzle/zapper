<?php

namespace Andizzle\Zapper;

use \Illuminate\Support\Facades\Config;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Artisan;

class Zapper extends \Illuminate\Foundation\Testing\TestCase {

    protected $useDatabase = TRUE;
    protected $test_db = NULL;


    /**
     * Since we are creating test db on the fly, we need switch to the Test DB
     */
    private function switchDB() {

        $default_db = Config::get('database.default');
        $default_db_config = 'database.connections.' . $default_db . '.database';
        $this->test_db = Config::get($default_db_config) . '_test_db';
        DB::statement('CREATE DATABASE IF NOT EXISTS ' . $this->test_db . ';');
        Config::set($default_db_config, $this->test_db);
        DB::reconnect();

    }

    /**
     * Migrate latest Db schema, also includes the schema in other packages
     */
    private function migrate() {

        Artisan::call('migrate');

        $registered_namespaces = array_keys($this->app['config']->getNamespaces());
        foreach( $registered_namespaces as $namespace ) {

            Artisan::call('migrate', array('--package' => $namespace));

        }

    }

    /**
     * Migrate & Seed the test DB
     */
    public function setUp() {

        parent::setUp();

        if( !$this->useDatabase )
            return;

        $this->switchDB();
        $this->migrate();
        $this->seed();

    }

    /**
     * Destroy the test DB
     */
    public function tearDown() {

        parent::tearDown();
        DB::statement('DROP DATABASE ' . $this->test_db. ';');

    }

    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication() {

        $unitTesting = true;
        $testEnvironment = 'testing';
        return require base_path() .  '/bootstrap/start.php';

    }

}
?>
