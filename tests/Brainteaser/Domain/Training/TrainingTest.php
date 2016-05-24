<?php
namespace Brainteaser\Domain\Training;

use PHPUnit_Framework_TestCase as UnitTest;
use \DateTime;

/**
 * @covers \Brainteaser\Domain\Training\Training
 */
class TrainingTest extends UnitTest
{
    /**
     * @return Training
     */
    private function createTraining()
    {
        return new Training(
            'xy',
            new DateTime('2016-05-01 18:00:00'),
            null,
            200
        );
    }
    
    public function testGetId()
    {
        $training = $this->createTraining();
        $this->assertEquals('xy', $training->getId());
    }

    public function testGetScore()
    {
        $training = $this->createTraining();
        $this->assertEquals(200, $training->getScore());
    }

    public function testGetNumExercises()
    {
        $training = $this->createTraining();
        $this->assertEquals(12, $training->getNumExercises());
    }

    public function testIncreaseScore()
    {
        $training = $this->createTraining();
        $training->increaseScore(100);
        $this->assertEquals(300, $training->getScore());
    }

    public function testIsFinished()
    {
        $training = $this->createTraining();
        $this->assertFalse($training->isFinished());
    }

    public function testMarkAsFinished()
    {
        $training = $this->createTraining();
        $training->markAsFinished();
        $this->assertTrue($training->isFinished());
    }
}