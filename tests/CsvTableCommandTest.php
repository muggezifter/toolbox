<?php

use Toolbox\Console\Command\CsvTableCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;


class CsvTableCommandTest extends PHPUnit_Framework_TestCase
{
    private $command;
    private $commandTester;


    public function setup()
    {
        $application = new Application();
        $application->add(new CsvTableCommand());
        $this->command = $application->find('csv:table');
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
            'filename'     => 'test1.csv',
        ));
        $regexp = '/| aap | noot | |/';
        $this->assertRegExp($regexp, $this->commandTester->getDisplay());
    }

    public function testTestfileWithWrongSeparatorGivesError()
    {
        $this->commandTester->execute(array(
            'command'      => $this->command->getName(),
            'filename'     => 'test1.csv',
            '--separator'  => "p",
        ));
        $regexp = '/ERROR: file must have at least two columns/';
        $this->assertRegExp($regexp, $this->commandTester->getDisplay());
    }


    public function testTestfileWithCorrectSeparatorIsProcessedCorrectly()
    {
        $this->commandTester->execute(array(
            'command'      => $this->command->getName(),
            'filename'     => 'test2.csv',
            '--separator'  => "p",
        ));
        $regexp = '/ aap  | noot | 2 |/';
        $this->assertRegExp($regexp, $this->commandTester->getDisplay());
    }


}