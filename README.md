Zapper - Laravel Test Builder
=============================

This is an attemp to make your test process eaiser when db is envolved.

What's missing in current test process?
---------------------------------------
In Laravel 4, you write your tests, put stuff in setUp() and tierDown(), and run phpunit. Which is all find except that there's no db envolved, or there is db envolved, but it's using your dev/staging db. Your test cases pickup existing data and blah blah blah... you know where I'm going.

What can you expect from Zapper?
--------------------------------
So all zapper does, is giving you an isolated test db where your all test queries are going to be executed. It builds the test db and drop it afterwards, and ohhh, it does migration (including your packages) and seeding for you.

How to use it?
--------------
It begin with put zapper to your composer.json

    "require": {
        "andizzle/zapper": "dev-master"
    }

After composer update you can start write your tests:

    <?php
    class MyTest extens Andizzle\Zapper\TestCase {
    
        public function testPostAuthCode() {}
    
    }
    ?>
    
TestCase and TransactionTestCase and Others
-------------------------------------------
Zapper offers two types of testcases for you, testcase and transaction testcase.

They all does the same drill except test case does rollback of your db and transaction truncate and reseeding at the beginning of each testcase.

If your tests requires db transactions then you can use TransactionTestCase, obviously...

Zapper actually reorder your tests so all testcases run before transaction testcases that may alter the database without restoring it to its original state.

Zapper also run other tests besides its TestCase and TransactionTestCase, at last.

Some helper commands
--------------------
There are some command that zapper uses. They are offered to you as well so you can do what you think fits.

    zapper:build_db        Create test DB.
    zapper:drop_db         Drop the test DB.
    zapper:migrate         Migrate schemas.
    zapper:run             Run tests.
    zapper:truncate        Truncate certain tables.
    
PR if you think it's shitty and feel like improving it.
-------------------------------------------------------


    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.