<?php

namespace App\Area;

use Exception;

/**
 * Keep data about area that is cleaned and not cleaned
 */
class FloorArea
{

    /**
     * @var float
     */
    private $_metersSquaredArea;

    /**
     * @var float
     */
    private $_metersSquaredCleaned;

    /**
     * @param double $_metersSquaredArea
     */
    public function __construct(float $metersSquaredArea)
    {
        $this->_metersSquaredArea = $metersSquaredArea;
        $this->_metersSquaredCleaned = 0;
    }

    /**
     * The Cleaner can clean the part of the area.
     *
     * @param float $metersSquared
     *
     * @return float|int
     * @throws \Exception
     */
    public function clean(float $metersSquared): float
    {
        if ($metersSquared > $this->_metersSquaredArea - $this->_metersSquaredCleaned) {
            throw new Exception("The cleaner can't clean more than its capacity.");
        } else {
            $this->_metersSquaredCleaned += $metersSquared;
        }
        return $this->_metersSquaredArea - $this->_metersSquaredCleaned - $metersSquared;
    }

    /**
     * What is the area that is not cleaned.
     *
     * @return float
     */
    public function getMaxCleaningArea(): float
    {
        return $this->_metersSquaredArea - $this->_metersSquaredCleaned;
    }

    /**
     * Is the job done - no more area to clean?
     *
     * @return bool
     */
    public function isCleaned(): bool
    {
        return $this->_metersSquaredCleaned >= $this->_metersSquaredArea;
    }
}
