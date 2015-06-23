<?php namespace Toolbox\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Toolbox\Models\Csv;
use Exception;

/**
 * Class CsvJsonCommand
 *
 * This command reads in a csv and outputs its JSON representation
 *
 * @package Toolbox\Console\Command
 */
class CsvJsonCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('csv:json')
            ->setDescription('Output content of csv file formatted as json')
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'Specify the name of the file you want to show'
            )
            ->addOption(
                'separator',
                null,
                InputOption::VALUE_REQUIRED,
                'Specify the character that is used to separate values in the csv file',
                ","
            );
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $csv = new Csv;

        try {
            $csv->writeAsJson(
                $input->getArgument('filename'),
                $input->getOption('separator'),
                $output
            );
        } catch (Exception $e) {
            $output->writeln("<error> ERROR: " . $e->getMessage() . " </error>");
        }
    }
}