<?php namespace Toolbox\Models;

use Symfony\Component\Console\Helper\Table;
use Exception;

Class Csv
{
    private $separator = ",";
    private $data = [];
    public $debug = false;
    public $headers = false;

    public function setSeparator($separator){
        // TODO: some validation code here
        switch ($separator)
        {
            case "p":
            case "pipe":
                $this->separator="|";
                break;
            default:
                $this->separator = $separator;
        }

    }

    public function read($filename)
    {
        if (!(is_file($filename) && is_readable($filename))) {
            throw new Exception('no such file');
        }

        $content = file_get_contents($filename);
        $lines = explode(PHP_EOL, $content);

        foreach ($lines as $line) {
            $this->data[] = str_getcsv($line,$this->separator);
        }


        if ($this->debug) {
            var_dump($this->data);
        }

        $this->validate($this->data);
    }


    private function validate($data)
    {
        if (count($data)<2) {
            throw new Exception('file must have at least two rows');
        }
        if (count($data[0])<2) {
            throw new Exception('file must have at least two columns');
        }
    }

    public function writeAsTable($output)
    {
        $table = new Table($output);

        if ($this->headers) {
            $table->setHeaders($this->data[0]);
        }
        $table->setRows(array_slice($this->data,$this->headers? 1:0));

        $table->render();
    }

//    public function getTableHeader()
//    {
//        return($this->data[0]);
//    }
//
//    public function getTableBody()
//    {
//        return array_slice($this->data,$this->headers? 1:0);
//    }
}