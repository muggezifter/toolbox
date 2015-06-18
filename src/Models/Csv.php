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
        if (! is_file($filename) || ! is_readable($filename)) {
            throw new Exception('no such file');
        }

        $s = $this->separator;

        $this->data = array_map(
            function ($value) use ($s)
            {
                return str_getcsv($value,$s);
            },
            file($filename)
        );

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

    public function writeAsJson($output)
    {
        $output->writeln(json_encode($this->data));
    }

}