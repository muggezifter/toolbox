<?php namespace Toolbox\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Toolbox\Models\Csv;
use Exception;

class CsvJsonCommand extends Command
{
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->csv = new Csv;

        if ($separator = $input->getOption('separator')) {
            $this->csv->setSeparator($separator);
        }

        if ($input->getOption('debug')) {
            $this->csv->debug = true;
        }


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