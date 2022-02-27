<?php

namespace Tests\DB;

use DB\DB;
use Helpers\DateTimeHelper;
use PHPUnit\Framework\TestCase;

require_once 'autoload.php';

class DateTimeHelperTest extends TestCase
{
    public function testCreateDateTime()
    {
        $dateTime = DateTimeHelper::createDateTime('12/02/2020 10:00:00');
        $this->assertSame($dateTime->format('d/m/Y H:i:s'), '12/02/2020 10:00:00');
    }

    public function testFormatNicelyWithTime()
    {
        $dateTimeNice = DateTimeHelper::formatNicely('12/02/2020 10:00:00');
        $this->assertSame($dateTimeNice, '12th February 2020 10:00 AM');
    }

    public function testFormatNicelyWithoutTime()
    {
        $dateTimeNice = DateTimeHelper::formatNicely('12/02/2020 10:00:00', false);
        $this->assertSame($dateTimeNice, '12th February 2020');
    }

}
