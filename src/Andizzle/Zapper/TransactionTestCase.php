<?php

namespace Andizzle\Zapper;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;


abstract class TransactionTestCase extends ZapperTestCase {

    /**
     * Migrate & Seed the test DB
     */
    public function setUp() {

        parent::setUp();

        if( !$this->use_database )
            return;

        Artisan::call('zapper:truncate');

        if( !in_array('--no-seed', $_SERVER['argv']) )
            Artisan::call('db:seed');

    }

}
?>
