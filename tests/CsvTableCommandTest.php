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
            'filename'     => 'example_1.csv',
        ));
        $substring = "| aap  | noot |  |\n| mies | wim  |  |";
        $this->assertContains($substring, $this->commandTester->getDisplay());
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
        $substring = "| aap  | noot | 2 |\n| mies | wim  | 3 |";
        $this->assertContains($substring, $this->commandTester->getDisplay());
    }

    public function testHeaderOptionWorksCorrectly() {
        $this->commandTester->execute(array(
            'command'      => $this->command->getName(),
            'filename'     => 'example_2.csv',
            '--separator'  => "p",
            '--headers'    => null,
        ));
        $substring = "| aap  | noot | 2 |\n+------+------+---+";
        $this->assertContains($substring, $this->commandTester->getDisplay());
    }


}