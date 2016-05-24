<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\Difficulty;
use Brainteaser\Domain\Exercise\GridSize;
use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;
use Brainteaser\Domain\Fixture\Exercise\ColoredTiles\ColoredTilesExerciseFixture;
use Brainteaser\Domain\Training\Training;
use DateTime;
use Mockery;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseFactory
 */
class ColoredTilesExerciseFactoryTest extends UnitTest
{
    /**
     * @return ColoredTilesExerciseFactory
     */
    private function createFactory()
    {
        /** @var Mockery\Mock|DifficultyFactory $difficultyFactory */
        $difficultyFactory = Mockery::mock('\Brainteaser\Domain\Exercise\ColoredTiles\DifficultyFactory');
        $difficultyFactory->shouldReceive('build')
            ->once()
            ->andReturn(new Difficulty(1));
        /** @var Mockery\Mock|GridSizeFactory $gridSizeFactory */
        $gridSizeFactory = Mockery::mock('\Brainteaser\Domain\Exercise\ColoredTiles\GridSizeFactory');
        $gridSizeFactory->shouldReceive('build')
            ->once()
            ->andReturn(new GridSize(4, 4));
        /** @var Mockery\Mock|ColoredTilesFactory $coloredTilesFactory */
        $coloredTilesFactory = Mockery::mock('\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesFactory');
        $coloredTilesFactory->shouldReceive('build')
            ->once()
            ->andReturn(
            new TileSet(
                [
                    new Tile(0, 0),
                    new Tile(1, 0),
                    new Tile(2, 0),
                    new Tile(3, 0),
                ]
            )
        );

        return new ColoredTilesExerciseFactory(
            $difficultyFactory,
            $gridSizeFactory,
            $coloredTilesFactory
        );
    }

    public function testBuildFirstExercise()
    {
        $factory = $this->createFactory();
        $exercise = $factory->build(
            new Training(
                'xy',
                new DateTime
            ),
            null,
            null
        );
        $this->assertInstanceOf(
            '\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise',
            $exercise
        );
        $this->assertEquals(
            1,
            $exercise->getSequenceNumber()->getValue()
        );
    }

    public function testBuild()
    {
        $factory = $this->createFactory();
        $lastExercise = ColoredTilesExerciseFixture::getUnsolved();
        $exercise = $factory->build(
            $lastExercise->getTraining(),
            $lastExercise,
            null
        );
        $this->assertInstanceOf(
            '\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise',
            $exercise
        );
        $this->assertEquals(
            2,
            $exercise->getSequenceNumber()->getValue()
        );
    }
}