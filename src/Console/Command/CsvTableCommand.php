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
 * This command reads in a csv and outputs the content as a table
 *
 * Class CsvTableCommand
 * @package Toolbox\Console\Command
 */
class CsvTableCommand extends Command
{

    /**
     * Configure command csv:json.
     */
    protected function configure()
    {
        $this
            ->setName('csv:table')
            ->setDescription('Output content of csv file formatted as table')
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
            )
            ->addOption(
                'headers',
                null,
                InputOption::VALUE_NONE,
                'First row has headers'
            );
    }


    /**
     * Execute command csv:table.
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
            $csvWriter->writeAsTable(
                $csv->read(
                    $input->getArgument('filename'),
                    $input->getOption('separator'),
                    $output),
                $input->getOption('headers'),
                $output
            );
        } catch (Exception $e) {
            $output->writeln("<error> ERROR: " . $e->getMessage() . " </error>");
        }
    }
}