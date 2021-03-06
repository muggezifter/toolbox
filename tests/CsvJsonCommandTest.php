<?php

use Toolbox\Console\Command\CsvJsonCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;


class CsvJsonCommandTest extends PHPUnit_Framework_TestCase
{
    private $command;
    private $commandTester;


    public function setup()
    {
        $application = new Application();
        $application->add(new CsvJsonCommand());
        $this->command = $application->find('csv:json');
        $this->commandTester = new CommandTester($this->command);
    }

    public function testNonExistingFilenameGivesError()
    {
        $this->commandTester->execute(array(
            'command'      => $this->command->getName(),
            'filename'     => 'nosuchfile.csv',
        ));
        $regexp = '/ERROR: no such file/';
        $this->assertRegExp($regexp, $this->commandTester->getDisplay());
    }


    public function testTestfileIsProcessedCorrectly()
    {
        $this->commandTester->execute(array(
            'command'      => $this->command->getName(),
            'filename'     => 'example_1.csv',
        ));
        $regexp = '/\[\["aap","noot",""\],\["mies","wim",""\],\["zus","jet",""\]\]/';
        $this->assertRegExp($regexp, $this->commandTester->getDisplay());
    }

    public function testTestfileWithWrongSeparatorGivesError()
    {
        $this->commandTester->execute(array(
            'command'      => $this->command->getName(),
            'filename'     => 'example_1.csv',
            '--separator'  => "p",
        ));
        $regexp = '/ERROR: file must have at least two columns/';
        $this->assertRegExp($regexp, $this->commandTester->getDisplay());
    }

    public function testTestfileWithCorrectSeparatorIsProcessedCorrectly()
    {
        $this->commandTester->execute(array(
            'command'      => $this->command->getName(),
            'filename'     => 'example_2.csv',
            '--separator'  => "p",
        ));
        $regexp = '/\[\["aap","noot","2"\],\["mies","wim","3"\],\["zus","jet","4"\]\]/';
        $this->assertRegExp($regexp, $this->commandTester->getDisplay());
    }


}