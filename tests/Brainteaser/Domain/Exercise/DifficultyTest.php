<?php
namespace Brainteaser\Domain\Exercise;

use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\Difficulty
 */
class DifficultyTest extends UnitTest
{
    public function testConstructWithValueTooLow()
    {
        $this->expectException('\InvalidArgumentException');
        new Difficulty(0);
    }

    public function testConstructWithValueTooHigh()
    {
        $this->expectException('\InvalidArgumentException');
        new Difficulty(13);
    }

    public function testGetValue()
    {
        $difficulty = new Difficulty(1);
        $this->assertEquals(1, $difficulty->getValue());
    }

    public function testDecrease()
    {
        $difficulty = new Difficulty(5);
        $difficulty = $difficulty->decrease();
        $this->assertEquals(4, $difficulty->getValue());
    }

    public function testDecreaseWillCapAt1()
    {
        $difficulty = new Difficulty(1);
        $difficulty = $difficulty->decrease();
        $this->assertEquals(1, $difficulty->getValue());
    }

    public function testIncrease()
    {
        $difficulty = new Difficulty(5);
        $difficulty = $difficulty->increase();
        $this->assertEquals(6, $difficulty->getValue());
    }

    public function testIncreaseWillCapAt12()
    {
        $difficulty = new Difficulty(12);
        $difficulty = $difficulty->increase();
        $this->assertEquals(12, $difficulty->getValue());
    }
}