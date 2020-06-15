<?php

namespace Area;

use PHPUnit\Framework\TestCase;
use App\Area\FloorArea;
use Exception;

class FloorAreaTest extends TestCase
{

    /**
     * Test algorithm for cleaning.
     *
     * @dataProvider getCleaningProvider
     *
     * @param $metersSquaredArea
     * @param $clean
     * @param $expectedMaxCleaningArea
     * @param $expectedIsCleaned
     *
     * @throws \Exception
     */
    public function testClean(
        float $metersSquaredArea,
        float $clean,
        float $expectedMaxCleaningArea,
        bool $expectedIsCleaned
    )
    {
        // ARRANGE
        $floorArea = new FloorArea($metersSquaredArea);

        // ACT
        $floorArea->clean($clean);
        $maxCleaningArea = $floorArea->getMaxCleaningArea();
        $isCleaned = $floorArea->isCleaned();

        // ASSERT
        $this->assertSame($expectedMaxCleaningArea, $maxCleaningArea);
        $this->assertSame($expectedIsCleaned, $isCleaned);
    }

    /**
     * Provides data for testClean.
     *
     * @return array
     */
    public function getCleaningProvider(): array
    {
        return [
            "Basic subtraction" => [70.0, 30.0, 40.0, false],
            "Clean whole area" => [30.0, 30.0, 0.0, true],
            "Zero area" => [0.0, 0.0, 0.0, true],
            "Float subtraction" => [0.8, 0.1, 0.7, false],
        ];
    }

    /**
     * Clean more than the area.
     *
     * @throws \Exception
     * @expectException Exception
     */
    public function testCleanMoreThanPossible()
    {
        // ARRANGE
        $floorArea = new FloorArea(10);

        // EXPECT
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("The cleaner can't clean more than its capacity.");

        // ASERT: Excide the max possible area to clean
        $floorArea->clean(10 + 1);
    }
}
