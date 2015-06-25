<?php namespace Toolbox\Models;

use Symfony\Component\Console\Helper\Table;
use Exception;

/**
 * This class holds functionality for toolbox commands in the csv: namespace
 *
 * Class Csv
 * @package Toolbox\Models
 * @todo This should be split in a class Csv and a class CsvWriter so the 'read' functionality could be tested separately
 */
Class Csv
{

    /**
     * Processes the separator.
     *
     * @param String $separator
     * @return string
     */
    private function separator($separator){
        switch ($separator)
        {
            case "p":
            case "pipe":
                return "|";
            default:
                return $separator;
        }
    }


    /**
     * Reads data from $filename, returns a 2-dimensional array representation.
     *
     * @param String $filename
     * @param String $separator
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return mixed
     * @throws Exception
     */
    private function read($filename,$separator,$output)
    {
        if (! is_file($filename) || ! is_readable($filename)) {
            throw new Exception('no such file');
        }

        $data = array_map(
            function ($value) use ($separator)
            {
                return str_getcsv($value,$separator);
            },
            file($filename)
        );

        return $this->validate($data,$output);
    }


    /**
     * Checks if the data has the minimum required number of columns and rows.
     *
     * @param Array $data
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return mixed
     * @throws Exception
     */
    private function validate($data,$output)
    {
        // debug info (-vvv option)
        if ($output->isVerbose()) {
            var_dump($data);
        }
        if (count($data)<2) {
            throw new Exception('file must have at least two rows');
        }
        if (count($data[0])<2) {
            throw new Exception('file must have at least two columns');
        }
        return $data;
    }


    /**
     * Writes the data in $filename to the console in tabular form.
     *
     * @param String $filename
     * @param String $separator
     * @param Boolean $headers
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @throws Exception
     */
    public function writeAsTable($filename,$separator,$headers,$output)
    {
        $table = new Table($output);

        $data = $this->read($filename,$this->separator($separator),$output);

        if ($headers) {
            $table->setHeaders($data[0]);
        }
        $table->setRows(array_slice($data,$headers? 1:0));

        $table->render();
    }


    /**
     * Writes the data in $filename to the console as JSON.
     *
     * @param String $filename
     * @param String $separator
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @throws Exception
     */
    public function writeAsJson($filename,$separator,$output)
    {
        $output->writeln(
            json_encode(
                $this->read(
                    $filename,
                    $this->separator($separator),
                    $output
                )));
    }

}