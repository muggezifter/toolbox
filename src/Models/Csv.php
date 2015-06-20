<?php namespace Toolbox\Models;

use Symfony\Component\Console\Helper\Table;
use Exception;

/**
 * Class Csv
 * @package Toolbox\Models
 */
Class Csv
{

    /**
     * @param $separator
     * @return string
     */
    public function separator($separator){
        switch ($separator)
        {
            case null:
                return ",";
            case "p":
            case "pipe":
                return "|";
            default:
                return $separator;
        }
    }

    /**
     * @param $filename
     * @return array
     * @throws Exception
     */
    public function read($filename,$separator)
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
        return $this->validate($data);
    }



    /**
     * @param $data
     * @return mixed
     * @throws Exception
     */
    private function validate($data)
    {
        if (count($data)<2) {
            throw new Exception('file must have at least two rows');
        }
        if (count($data[0])<2) {
            throw new Exception('file must have at least two columns');
        }
        return $data;
    }


    /**
     * @param $data
     * @param $headers
     * @param $output
     */
    public function writeAsTable($data,$headers,$output)
    {
        $table = new Table($output);

        if ($headers) {
            $table->setHeaders($data[0]);
        }
        $table->setRows(array_slice($data,$this->headers? 1:0));

        $table->render();
    }

    /**
     * @param $data
     * @param $output
     */
    public function writeAsJson($data,$output)
    {
        $output->writeln(json_encode($data));
    }

}