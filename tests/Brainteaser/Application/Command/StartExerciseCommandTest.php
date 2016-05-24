<?php
namespace Brainteaser\Application\Command;

use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Application\Command\StartExerciseCommand
 */
class StartExerciseCommandTest extends UnitTest
{
    public function testGetTraining()
    {
        $command = new StartExerciseCommand('xy');
        $this->assertEquals('xy', $command->getTrainingId());
    }
}