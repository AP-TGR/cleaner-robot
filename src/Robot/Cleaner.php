<?php

namespace App\Robot;

use App\Area\FloorArea;
use App\Speed\FloorTypeSpeed;
use App\Power\Battery;
use App\Robot\Robot;

/**
 * All pieces of robot together.
 */
class Cleaner extends Robot
{

    /**
     * Types of floor the cleaner supports
     *
     * @var array
     */
    const FLOOR_TYPES = [
        'hard' => 1,
        'carpet' => 0.5
    ];

    /**
     * @var integer
     */
    const MINUTES_POWER = 60;

    /**
     * @var integer
     */
    const MINUTES_CHARGE = 30;

    /**
     * @var FloorArea
     */
    private $_floorArea;

    /**
     * @var FloorTypeSpeed
     */
    private $_floorTypeSpeed;

    /**
     * @var BatteryPower
     */
    private $_batteryPower;

    /**
     * @param string $floorType
     * @param float $area
     */
    public function __construct(string $floorType, float $area)
    {
        $this->_batteryPower = new Battery(
            $this::MINUTES_POWER,
            $this::MINUTES_CHARGE
        );
        $this->_floorArea = new FloorArea($area);
        $this->_floorTypeSpeed = new FloorTypeSpeed($this::FLOOR_TYPES[$floorType]);
    }

    /**
     * Logic to clean the area
     *
     * @return array
     * @throws \Exception
     */
    public function run(): array
    {
        $tasks = [];
        $i = 0;
        while (true) {
            $i++;
            [
                $area,
                $cleaningTime,
            ] = $this->getCleaningAreaTime();

            //Work
            $this->_floorArea->clean($area);
            $this->_batteryPower->work($cleaningTime);
            $tasks["cleanning_" . $i] = $cleaningTime;

            //Charge
            $timeToCharge = $this->_batteryPower->charge();
            $tasks["charging_" . $i] = $timeToCharge;
            if ($this->_floorArea->isCleaned()) {
                break;
            }
        }
        return $tasks;
    }

    /**
     * Find the size of area and time that can be used for cleaning.
     *
     * @return array
     */
    private function getCleaningAreaTime()
    {
        // Get the max working time as per battery
        $maxWorkingTime = $this->_batteryPower->getMaxWorkingTime();

        // Get maximum arae to clean
        $maxCleaningArea = $this->_floorArea->getMaxCleaningArea();

        // Get maximum time and are to clean
        $areaToCleanInMaxTime = $this->_floorTypeSpeed->getAreaForTime($maxWorkingTime);
        $maxCleaningAreaTime = $this->_floorTypeSpeed->getTimeForArea($maxCleaningArea);

        return [
            // Minumum area to clean
            min($areaToCleanInMaxTime, $maxCleaningArea),

            // Minimum time to clean
            min($maxWorkingTime, $maxCleaningAreaTime),
        ];
    }
}
