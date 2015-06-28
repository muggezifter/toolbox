<?php namespace Toolbox\Models;

use Symfony\Component\Console\Helper\Table;

/**
 * This class holds functions that write the contents of a csv file to the console.
 *
 * Class CsvWriter
 * @package Toolbox\Models
*/
class CsvWriter 
{
    /**
     * Writes the data in $filename to the console in tabular form.
     *
     * @param String $filename
     * @param String $separator
     * @param Boolean $headers
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @throws Exception
     */
    public function writeAsTable($data,$headers,$output)
    {
        $table = new Table($output);

      
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
    public function writeAsJson($data,$output)
    {
        $output->writeln(json_encode($data));
    }

}
