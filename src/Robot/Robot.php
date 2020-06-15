<?php

namespace App\Robot;

use App\Power\Battery;

abstract class Robot
{

    /**
     * Source of power for the robot
     *
     * @var null|
     */
    protected $_battery = null;

    /**
     * Constructor
     *
     * @param Battery $battery
     */
    public function __construct(Battery $battery)
    {
        $this->_battery = $battery;
    }

    abstract public function run();
}
