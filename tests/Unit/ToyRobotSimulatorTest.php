<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\CustomClass\ToyRobotSimulator;

class ToyRobotSimulatorTest extends TestCase
{
    public function testRobotIsWithinValidRange(ToyRobotSimulator $trs)
    {
        $result = $trs->isWithinValidRange(0,4);
        $this->assertTrue($result);
    }

    public function testRobotIsNotWithinValidRange(ToyRobotSimulator $trs)
    {
        $result = $trs->isWithinValidRange(5,4);
        $this->assertFalse($result);
    }
}
