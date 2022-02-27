<?php

namespace Tests\DB;

use DB\DB;
use PHPUnit\Framework\TestCase;

require_once 'autoload.php';

class DBTest extends TestCase
{
    public function testDBGet()
    {
        DB::set('testKey', 'testValue');

        $this->assertSame(DB::get('testKey'), 'testValue');
    }

    public function testDBFindByID()
    {
        DB::set('students', [
            'student1' => 'testValue'
        ]);

        $this->assertSame(DB::findById('students', 'student1'), 'testValue');
    }

}
