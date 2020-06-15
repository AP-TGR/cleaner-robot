<?php

namespace App\Power;

use Exception;

/**
 * Encapsulate the logic for battery
 *
 */
class Battery
{

    /**
     * @var float
     */
    private $_workMinutes;

    /**
     * @var float
     */
    private $_chargingMinute;

    /**
     * @var float
     */
    private $_capacity;

    /**
     * @param float $workMinutes
     * @param float $chargingMinute
     * @return void
     */
    public function __construct(float $workMinutes, float $chargingMinute)
    {
        $this->_workMinutes = $workMinutes;
        $this->_chargingMinute = $chargingMinute;
        $this->_capacity = 1;
    }

    /**
     * Capacity of the battery
     *
     * @return float
     */
    public function getMaxWorkingTime(): float
    {
        return $this->_workMinutes * $this->_capacity;
    }

    /**
     * Charge the battery.
     *
     * @return float
     */
    public function charge(): float
    {
        return $this->_chargingMinute * (1 - $this->_capacity);
    }

    /**
     * Use the battery.
     *
     * @param float $seconds
     *
     * @throws \Exception
     */
    public function work(float $seconds)
    {
        if ($seconds <= $this->getMaxWorkingTime()) {
            $this->_capacity = 1 - ($seconds / $this->_workMinutes);
        } else {
            throw new Exception("Battery does not have capacity.");
        }
    }
}
