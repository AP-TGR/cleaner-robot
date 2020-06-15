<?php

namespace App\Speed;

/**
 * Speed of cleaner based on floor type.
 */
class FloorTypeSpeed
{

    /**
     * @var float
     */
    private $_cleaningSpeed;

    /**
     * @param double $_cleaningSpeed
     */
    public function __construct(float $_cleaningSpeed)
    {
        $this->_cleaningSpeed = $_cleaningSpeed;
    }

    /**
     * The area that can be cleaned in time.
     *
     * @param float $seconds
     *
     * @return float
     */
    public function getAreaForTime(float $seconds): float
    {
        return $seconds * $this->_cleaningSpeed;
    }

    /**
     * The time that is needed for cleaning the area.
     *
     * @param float $metersSquaredArea
     *
     * @return float
     */
    public function getTimeForArea(float $metersSquaredArea): float
    {
        return $metersSquaredArea / $this->_cleaningSpeed;
    }
}
