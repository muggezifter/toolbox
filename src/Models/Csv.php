<?php namespace Toolbox\Models;

use Symfony\Component\Console\Helper\Table;
use Exception;

/**
 * Class Csv
 * @package Toolbox\Models
 */
Class Csv
{
    // this wil hold a two dimensional array representing the content of the file:
    private $data = [[]];
    // these will hold the values set by the options:
    private $separator = ",";
    public $debug = false;
    public $headers = false;

    /**
     * For this option we use a setter because we need to do some processing on the value;
     * for the other options that would be unnecessary overhead.
     *
     * @param $separator
     */
    public function setSeparator($separator){
        // TODO: some validation code here
        switch ($separator)
        {
            case null:
                $this->separator=",";
                break;
            case "p":
            case "pipe":
                $this->separator="|";
                break;
            default:
                $this->separator = $separator;
        }
    }

    /**
     * @param $filename
     * @throws Exception
     */
    public function read($filename)
    {
        if (! is_file($filename) || ! is_readable($filename)) {
            throw new Exception('no such file');
        }

        // We need to do this because we need the value in the closure:
        $s = $this->separator;

        $this->data = array_map(
            function ($value) use ($s)
            {
                return str_getcsv($value,$s);
            },
            file($filename)
        );

        if ($this->debug) {
            var_dump($this);
        }

        $this->validate($this->data);
    }


    /**
     * @param $data
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
    }

    /**
     * @param $output
     */
    public function writeAsTable($output)
    {
        $table = new Table($output);

        if ($this->headers) {
            $table->setHeaders($this->data[0]);
        }
        $table->setRows(array_slice($this->data,$this->headers? 1:0));

        $table->render();
    }

    /**
     * @param $output
     */
    public function writeAsJson($output)
    {
        $output->writeln(json_encode($this->data));
    }

}