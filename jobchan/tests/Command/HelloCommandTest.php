<?php
namespace Jobchan\Command;

use Jobchan\App;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class HelloCommandTest extends TestCase
{
    public function testExecute()
    {
        $app = (new App(new Application()))->get();

        $command = $app->find('hello');

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),
            'name' => 'World'
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Hello World', $output);
    }
}
