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
 * @package Toolbox\Console\Command
 */
class CsvJsonCommand extends Command
{
    // This will hold a Csv object:
    private $csv;

    protected function configure()
    {
        $this
            ->setName('csv:json')
            ->setDescription('Output content of csv file formatted as json')
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'Which file do you want to show?'
            )
            ->addOption(
                'separator',
                null,
                InputOption::VALUE_REQUIRED,
                'Which character is used to separate values in the csv file?'
            )
            ->addOption(
                'debug',
                null,
                InputOption::VALUE_NONE,
                'Show debug information'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->csv = new Csv;

        $this->csv->setSeparator($input->getOption('separator'));

        $this->csv->debug = $input->getOption('debug');

        $filename = $input->getArgument('filename');

        try {
            $this->csv->read($filename);
            $this->csv->writeAsJson($output);
        } catch (Exception $e) {
            $output->writeln("<error> ERROR: " . $e->getMessage() . " </error>");
            exit;
        }


    }
}