<?php
namespace Brainteaser\Application\DataTransformer;

use Brainteaser\Domain\Exercise\ColoredTiles\SolveColoredTilesExerciseResult;
use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Application\DataTransformer\SolveColoredTilesExerciseResultDataTransformer
 */
class SolveColoredTilesExerciseResultDataTransformerTest extends UnitTest
{
    public function testTransform()
    {
        $item = new SolveColoredTilesExerciseResult(
            new TileSet(
                [
                    new Tile(0, 0)
                ]
            ),
            new TileSet(
                [
                    new Tile(1, 0)
                ]
            ),
            new TileSet(
                [
                    new Tile(2, 0),
                    new Tile(3, 0)
                ]
            ),
            100
        );
        $dataTransformer = new SolveColoredTilesExerciseResultDataTransformer();

        $expectedData = [
            'correct' => [
                [
                    'x' => 0, 'y' => 0
                ]
            ],
            'wrong' => [
                [
                    'x' => 1, 'y' => 0
                ]
            ],
            'missing' => [
                [
                    'x' => 2, 'y' => 0
                ],
                [
                    'x' => 3, 'y' => 0
                ],
            ],
            'score' => 100
        ];
        
        $this->assertEquals(
            $expectedData,
            $dataTransformer->transform($item)
        );
    }
}