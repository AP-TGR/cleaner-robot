<?php

namespace App\Command;

use App\Robot\Cleaner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command control
 */
class RobotCommand extends Command
{

    /**
     * Command configuration
     */
    protected function configure()
    {
        $this->setName('clean')
            ->setDescription('Robot for cleaning.')
            ->setHelp('Robot for cleaning that can charge itself.')
            ->addOption(
                'floor',
                null,
                InputOption::VALUE_REQUIRED,
                'Type of floor.'
            )
            ->addOption(
                'area',
                null,
                InputOption::VALUE_REQUIRED,
                'Area in meter squared.'
            );
    }

    /**
     * Execute command
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null|void
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->clean($input, $output);
    }

    /**
     * Hoover Output and sleeping
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @throws \Exception
     */
    protected function clean(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '==============Cleaning Start==============',
            '',
        ]);
        $floor = $input->getOption('floor');
        $area = $input->getOption('area');
        $isFloorValid = $this->isFloorTypeValid($floor);
        $isAreaValid = $this->isAreaValid($area);
        $floorMessage = ($isFloorValid) ? "" : " - not valid";
        $areaMessage = ($isAreaValid) ? "" : " - not valid";

        $output->writeln("floor: " . $floor . $floorMessage);
        $output->writeln("area: " . $area . $areaMessage);
        $output->writeln('==========================================');

        if ($isFloorValid and $isAreaValid) {
            $robot = new Cleaner($input->getOption('floor'), floatval($input->getOption('area')));
            $tasks = $robot->run();
            foreach ($tasks as $taskType => $taskTime) {
                $output->writeln($taskType . ": " . $taskTime . "s");
                sleep(intval($taskTime));
            }
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }

    /**
     * Check floor is valid
     *
     * @param $floorType
     *
     * @return bool
     */
    private function isFloorTypeValid($floorType)
    {
        if (array_key_exists($floorType, Cleaner::FLOOR_TYPES)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check area is valid
     *
     * @param $area
     *
     * @return bool
     */
    private function isAreaValid($area)
    {
        if (is_numeric($area) and $area > 0) {
            return true;
        } else {
            return false;
        }
    }
}
