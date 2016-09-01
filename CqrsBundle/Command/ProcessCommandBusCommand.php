<?php


namespace Torpedo\CqrsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Torpedo\CQRS\Command\CommandBus;

final class ProcessCommandBusCommand extends ContainerAwareCommand
{
    const BASE_SLEEP_MICROSECONDS = 2500;

    protected function configure()
    {
        $this
            ->setName('torpedo:cqrs:process-command-bus')
            ->setDescription('Start a worker to process commands on a command bus')
            ->addOption('batch-size', 'b', InputOption::VALUE_OPTIONAL, "Amount of commands to process in one run",
                10000)
            ->addOption('command-bus', 'c', InputOption::VALUE_REQUIRED,
                "DI Key to specify the Command Bus to process");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $commandBus CommandBus */
        $commandBus = $this->getContainer()->get($input->getOption('command-bus'));
        $batchSize = $input->getOption('batch-size');

        $sleepTimeInMicroseconds = $this->getPreferredSleepTime();

        foreach (range(1, $batchSize) as $i) {
            try {
                $commandBus->dispatchNext();
            } catch (\Exception $e) {
            }

            usleep($sleepTimeInMicroseconds); //give the server the time to do some other things...

        }
    }

    private function getPreferredSleepTime(): int
    {
        list($now, $fiveAgo, $fifteenAgo) = sys_getloadavg();
        return round(ProcessCommandBusCommand::BASE_SLEEP_MICROSECONDS * $fifteenAgo);
    }
}