<?php

namespace Andizzle\Zapper;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;


abstract class TestCase extends ZapperTestCase {

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

        if( !$this->use_database )
            return;

        $this->pdo->rollBack();

    }

}
?>
