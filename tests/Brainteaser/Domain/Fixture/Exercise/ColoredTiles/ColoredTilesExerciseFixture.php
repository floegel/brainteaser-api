<?php
namespace Brainteaser\Domain\Fixture\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise;
use Brainteaser\Domain\Exercise\Difficulty;
use Brainteaser\Domain\Exercise\GridSize;
use Brainteaser\Domain\Exercise\SequenceNumber;
use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;
use Brainteaser\Domain\Training\Training;
use DateTime;

class ColoredTilesExerciseFixture
{
    /**
     * @return ColoredTilesExercise
     */
    public static function getUnsolved() : ColoredTilesExercise
    {
        return new ColoredTilesExercise(
            'xy',
            new SequenceNumber(1),
            new Training(
                'tr',
                new DateTime
            ),
            new Difficulty(1),
            new GridSize(4,4),
            new TileSet(
                [
                    new Tile(0,0),
                    new Tile(1,0),
                    new Tile(2,0),
                    new Tile(3,0),
                ]
            ),
            new DateTime('2016-05-01 18:00:00')
        );
    }

    /**
     * @param int $difficulty
     * @return ColoredTilesExercise
     */
    public static function getSolved(int $difficulty = 1) : ColoredTilesExercise
    {
        return new ColoredTilesExercise(
            'xy',
            new SequenceNumber(1),
            new Training(
                'tr',
                new DateTime
            ),
            new Difficulty($difficulty),
            new GridSize(4,4),
            new TileSet(
                [
                    new Tile(0,0),
                    new Tile(1,0),
                    new Tile(2,0),
                    new Tile(3,0),
                ]
            ),
            new DateTime('2016-05-01 18:00:00'),
            new DateTime('2016-05-01 18:00:05'),
            50
        );
    }

    /**
     * @return ColoredTilesExercise
     */
    public static function getSolvedPerfectly() : ColoredTilesExercise
    {
        return new ColoredTilesExercise(
            'xy',
            new SequenceNumber(1),
            new Training(
                'tr',
                new DateTime
            ),
            new Difficulty(1),
            new GridSize(4,4),
            new TileSet(
                [
                    new Tile(0,0),
                    new Tile(1,0),
                    new Tile(2,0),
                    new Tile(3,0),
                ]
            ),
            new DateTime('2016-05-01 18:00:00'),
            new DateTime('2016-05-01 18:00:05'),
            100
        );
    }
}