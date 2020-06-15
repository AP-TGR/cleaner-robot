<?php

namespace Tests\Robot;

use App\Robot\Cleaner;
use PHPUnit\Framework\TestCase;

class CleanerTest extends TestCase
{

    /**
     * @dataProvider getTestRunProvider
     *
     * @param $floorType
     * @param $area
     *
     * @param $expectedTasks
     *
     * @throws \Exception
     */
    public function testRun(string $floorType, float $area, array $expectedTasks)
    {
        // ARRANGE
        $cleaner = new Cleaner($floorType, $area);

        // ACT
        $tasks = $cleaner->run();

        // ASSERT
        $this->assertSame($tasks, $expectedTasks);
    }

    /**
     * Provides data for testRun.
     *
     * @return array
     */
    public function getTestRunProvider(): array
    {
        return [
            "hard" => ["hard", 60.0, ["cleanning_1" => 60.0, "charging_1" => 30.0]],
            "carpet" => ["carpet", 30.0, ["cleanning_1" => 60.0, "charging_1" => 30.0]]
        ];
    }
}
