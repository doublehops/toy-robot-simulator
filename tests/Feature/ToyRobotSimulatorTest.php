<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\CustomClass\ToyRobotSimulator;

class ToyRobotSimulatorTest extends TestCase
{

    public function testPlaceRobotSuccessfully()
    {
        $trs = new ToyRobotSimulator;
        $trs->place(0,1,'N');
        $report = $trs->report();

        $this->assertEquals(0, $this->splitReport($report)[0]);
        $this->assertEquals(1, $this->splitReport($report)[1]);
        $this->assertEquals('N', $this->splitReport($report)[2]);
    }

    public function testPlaceRobotWithBadPosition()
    {
        $trs = new ToyRobotSimulator;
        $result = $trs->place(0,9,'N');
        $this->assertFalse($result);
    }

    public function testAssertCanOnlyPlaceOnce()
    {
        $trs = new ToyRobotSimulator;
        $trs->place(0,1,'N');
        $result = $trs->place(0,1,'N');
        $this->assertFalse($result);
    }

    public function testLeft()
    {
        $trs = new ToyRobotSimulator;
        $trs->place(0,0,'N');
        $trs->left();
        $report = $trs->report();

        $this->assertEquals('W', $this->splitReport($report)[2]);
    }

    protected function splitReport($report)
    {
        return explode(',', $report);
    }
}
