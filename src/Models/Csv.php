<?php namespace Toolbox\Models;

use Exception;

Class Csv 
{
	private $separator = ",";
	private $data;
	public $debug = true;

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

		$this->data = str_getcsv(file_get_contents($filename));
		
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

}