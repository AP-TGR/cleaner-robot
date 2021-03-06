<?php

namespace Tests\Command;

use App\Command\RobotCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Output\Output;

class RobotCommandTest extends TestCase
{

    /**
     * Test the invalid inputs
     *
     * @throws \Exception
     */
    public function testWrongInputs()
    {
        // ARRANGE
        $inputMock = $this->createMock(Input::class);
        $outputMock = $this->createMock(Output::class);

        // Methods
        $inputMock->expects($this->any())
            ->method('getOption')
            ->will($this->returnCallback([$this, 'getDataPerParameter']));
        $outputMock->expects($this->at(1))
            ->method("writeln")
            ->will($this->returnCallback([$this, "wrongFloorValue"]));
        $outputMock->expects($this->at(2))
            ->method("writeln")
            ->will($this->returnCallback([$this, "wrongAreaValue"]));
        
        $robotCommand = new RobotCommand();

        // ACT && ASSERT
        $robotCommand->run($inputMock, $outputMock);
    }

    /**
     * Assert for area value
     *
     * @param $areaMessage
     */
    public function wrongAreaValue(string $areaMessage)
    {
        $this->assertContains(" - not valid", $areaMessage);
    }

    /**
     * Assert for floor value
     *
     * @param $floorMessage
     */
    public function wrongFloorValue(string $floorMessage)
    {
        $this->assertContains(" - not valid", $floorMessage);
    }

    /**
     * Test values
     *
     * @return string
     */
    public function getDataPerParameter(): string
    {
        $args = func_get_args();
        if ($args[0] === "floor") {
            return "non carpet";
        } elseif ($args[0] === "area") {
            return "-20";
        }
    }
}
