<?php

use Toolbox\Models\Csv;

class CsvTest extends PHPUnit_Framework_TestCase
{
    protected $csv;
    protected $output;

    protected function setup()
    {
        $this->csv = new Csv;
    }

    public function testCsvObjectCanBeInstantiated()
    {
        $this->assertInstanceOf("Toolbox\\Models\\Csv",$this->csv,"message");
    }
}