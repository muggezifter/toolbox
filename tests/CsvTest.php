<?php

use Toolbox\Models\Csv;

/**
 * This is not a particularly useful test; it is included as a gesture towards
 * the idea that code is not really complete if there are no tests
 */
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