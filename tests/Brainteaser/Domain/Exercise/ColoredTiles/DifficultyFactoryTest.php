<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Fixture\Exercise\ColoredTiles\ColoredTilesExerciseFixture;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\ColoredTiles\DifficultyFactory
 */
class DifficultyFactoryTest extends UnitTest
{
    public function testBuildThrowsPreviousUnsolvedExerciseExceptionForLastExercise()
    {
        $this->expectException('\Brainteaser\Domain\Exercise\PreviousUnsolvedExerciseException');
        $factory = new DifficultyFactory();
        $lastExercise = ColoredTilesExerciseFixture::getUnsolved();
        $factory->build(
            $lastExercise,
            null
        );
    }

    public function testBuildThrowsPreviousUnsolvedExerciseExceptionForSecondToLastExercise()
    {
        $this->expectException('\Brainteaser\Domain\Exercise\PreviousUnsolvedExerciseException');
        $factory = new DifficultyFactory();
        $lastExercise = ColoredTilesExerciseFixture::getSolved();
        $secondToLastExercise = ColoredTilesExerciseFixture::getUnsolved();
        $factory->build(
            $lastExercise,
            $secondToLastExercise
        );
    }

    public function testBuildWithNoPreviousExercises()
    {
        $factory = new DifficultyFactory();
        $difficulty = $factory->build(
            null,
            null
        );
        $this->assertEquals(1, $difficulty->getValue());
    }

    public function testBuildThrowsExceptionOnInvalidInput()
    {
        $this->expectException('\InvalidArgumentException');
        $factory = new DifficultyFactory();
        $factory->build(
            null,
            ColoredTilesExerciseFixture::getSolved()
        );
    }

    public function testBuildWithOnlyLastExerciseGiven()
    {
        $factory = new DifficultyFactory();
        $difficulty = $factory->build(
            ColoredTilesExerciseFixture::getSolved(),
            null
        );
        $this->assertEquals(1, $difficulty->getValue());
    }

    public function testBuildWithOnlyLastExerciseGivenAndSolvedPerfectly()
    {
        $factory = new DifficultyFactory();
        $difficulty = $factory->build(
            ColoredTilesExerciseFixture::getSolvedPerfectly(),
            null
        );
        // should be increased
        $this->assertEquals(2, $difficulty->getValue());
    }

    public function testBuildWithTwoExercisesNotSolvedPerfectly()
    {
        $factory = new DifficultyFactory();
        $difficulty = $factory->build(
            ColoredTilesExerciseFixture::getSolved(2),
            ColoredTilesExerciseFixture::getSolved(2)
        );
        // should be decrease
        $this->assertEquals(1, $difficulty->getValue());
    }

    public function testBuildWithTwoExercises()
    {
        $factory = new DifficultyFactory();
        $difficulty = $factory->build(
            ColoredTilesExerciseFixture::getSolved(2),
            ColoredTilesExerciseFixture::getSolvedPerfectly()
        );
        // should stay the same
        $this->assertEquals(2, $difficulty->getValue());
    }
}