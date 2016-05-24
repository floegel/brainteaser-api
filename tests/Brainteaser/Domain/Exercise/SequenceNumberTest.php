<?php
namespace Brainteaser\Domain\Exercise;

use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\SequenceNumber
 */
class SequenceNumberTest extends UnitTest
{
    public function testConstructWithValueTooLow()
    {
        $this->expectException('\InvalidArgumentException');
        new SequenceNumber(0);
    }

    public function testConstructWithValueTooHigh()
    {
        $this->expectException('\Brainteaser\Domain\Training\TrainingAmountOfExercisesExceededException');
        new SequenceNumber(13);
    }

    public function testGetValue()
    {
        $sequenceNumber = new SequenceNumber(1);
        $this->assertEquals(1, $sequenceNumber->getValue());
    }

    public function testIncrease()
    {
        $sequenceNumber = new SequenceNumber(1);
        $sequenceNumber = $sequenceNumber->increase();
        $this->assertEquals(2, $sequenceNumber->getValue());
    }

    public function testIncreaseFailsWithValueTooHigh()
    {
        $this->expectException('\Brainteaser\Domain\Training\TrainingAmountOfExercisesExceededException');
        $sequenceNumber = new SequenceNumber(12);
        $sequenceNumber->increase();
    }
}