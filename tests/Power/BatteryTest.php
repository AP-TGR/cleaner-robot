<?php

namespace Tests\Power;

use App\Power\Battery;
use PHPUnit\Framework\TestCase;
use Exception;

class BatteryTest extends TestCase
{

    /**
     * Test loosing battery capacity.
     *
     * @dataProvider getTestWorkProvider
     *
     * @param $minutesPower
     * @param $workTime
     * @param $expectedMinutesCapacity
     *
     * @throws \Exception
     */
    public function testWork(float $minutesPower, float $workTime, float $expectedMinutesCapacity)
    {
        // ARRANGE
        $battery = new Battery($minutesPower, 0);

        // ACT
        $battery->work($workTime);
        $minutesCapacity = $battery->getMaxWorkingTime();

        // ASSERT
        $this->assertSame($expectedMinutesCapacity, $minutesCapacity);
    }

    /**
     * Provides data for testWork.
     *
     * @return array
     */
    public function getTestWorkProvider(): array
    {
        return [
            "Half battery after work" => [60.0, 30.0, 30.0],
            "Empty battery after work" => [60.0, 60.0, 0.0],
        ];
    }

    /**
     * Test charging
     *
     * @dataProvider getTestChargeProvider
     *
     * @param $minutesPower
     * @param $workTime
     * @param $minutesCharge
     * @param $expectedMinutesCharge
     *
     * @throws \Exception
     */
    public function testCharge(
        float $minutesPower,
        float $workTime,
        float $minutesCharge,
        float $expectedMinutesCharge
    )
    {
        // ARRANGE
        $battery = new Battery($minutesPower, $minutesCharge);

        // ACT
        $battery->work($workTime);
        $minutesCharge = $battery->charge();

        // ASSERT
        $this->assertSame($expectedMinutesCharge, $minutesCharge);
    }

    /**
     * Provides data for testCharge.
     *
     * @return array
     */
    public function getTestChargeProvider(): array
    {
        return [
            "Half battery after work" => [60.0, 30.0, 30.0, 15.0],
            "Empty battery after work" => [60.0, 60.0, 30.0, 30.0],
            "Full battery after work" => [60.0, 0.0, 30.0, 0.0],
        ];
    }

    /**
     * Work more than the capacity of battery.
     *
     * @throws \Exception
     */
    public function testWorkMoreThanCapacity()
    {
        $battery = new Battery(60, 30);
        $this->expectException(Exception::class);
        $battery->work(61);
    }
}
