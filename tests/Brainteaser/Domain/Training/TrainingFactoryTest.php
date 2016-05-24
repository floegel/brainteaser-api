<?php
namespace Brainteaser\Domain\Training;

use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Training\TrainingFactory
 */
class TrainingFactoryTest extends UnitTest
{
    public function testBuild()
    {
        $trainingFactory = new TrainingFactory();
        $training = $trainingFactory->build();
        
        $this->assertEquals('', $training->getId());
        $this->assertFalse($training->isFinished());
        $this->assertEquals(0, $training->getScore());
        $this->assertEquals(12, $training->getNumExercises());
    }
}