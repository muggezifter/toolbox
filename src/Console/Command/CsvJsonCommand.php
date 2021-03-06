<?php namespace Toolbox\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Toolbox\Models\Csv;
use Toolbox\Models\CsvWriter;
use Exception;

/**
 * This command reads in a csv and outputs its JSON representation
 *
 * Class CsvJsonCommand
 * @package Toolbox\Console\Command
 */
class CsvJsonCommand extends Command
{

    /**
     * Configure command csv:json.
     */
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
     * Execute command csv:json.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $csv = new Csv;
        $csvWriter = new CsvWriter;

        try {
            $csvWriter->writeAsJson(
                $csv->read(
                    $input->getArgument('filename'),
                    $input->getOption('separator'),
                    $output),
                $output
            );
        } catch (Exception $e) {
            $output->writeln("<error> ERROR: " . $e->getMessage() . " </error>");
        }
    }
}