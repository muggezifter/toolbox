<?php namespace Toolbox\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Toolbox\Models\Csv;
use Exception;

class CsvShowCommand extends Command
{
    private $csv;

    protected function configure()
    {
        $this
            ->setName('csv:show')
            ->setDescription('Show formatted content of csv file')
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
               'headers',
               null,
               InputOption::VALUE_NONE,
               'First row has headers'
            )
            ->addOption(
               'debug',
               null,
               InputOption::VALUE_NONE,
               'Show debug information'
            )
        ;
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

        if ($input->getOption('headers')) {
            $this->csv->headers = true;
        }


        $filename = $input->getArgument('filename');
        try {
            $this->csv->read($filename);
        } 
        catch (Exception $e) {
            $output->writeln("ERROR:" . $e->getMessage());
            exit;
        }
        $table = new Table($output);
        if ($this->csv->headers) {
            $table->setHeaders($this->csv->getTableHeader());
        }
        $table->setRows($this->csv->getTableBody());

        $table->render();


    }
}