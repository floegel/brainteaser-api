<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\ColoredTiles\SolveColoredTilesExerciseResult
 */
class SolveColoredTilesExerciseResultTest extends UnitTest
{
    /**
     * @return SolveColoredTilesExerciseResult
     */
    private function createSolveColoredTilesExerciseResult() : SolveColoredTilesExerciseResult
    {
        return new SolveColoredTilesExerciseResult(
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
    }

    public function testGetCorrectTiles()
    {
        $result = $this->createSolveColoredTilesExerciseResult();
        $expectedTiles = new TileSet(
            [
                new Tile(0, 0)
            ]
        );
        $this->assertTrue($expectedTiles->equals($result->getCorrectTiles()));
    }

    public function testGetWrongTiles()
    {
        $result = $this->createSolveColoredTilesExerciseResult();
        $expectedTiles = new TileSet(
            [
                new Tile(1, 0)
            ]
        );
        $this->assertTrue($expectedTiles->equals($result->getWrongTiles()));
    }

    public function testGetMissingTiles()
    {
        $result = $this->createSolveColoredTilesExerciseResult();
        $expectedTiles = new TileSet(
            [
                new Tile(2, 0),
                new Tile(3, 0)
            ]
        );
        $this->assertTrue($expectedTiles->equals($result->getMissingTiles()));
    }

    public function testGetScore()
    {
        $result = $this->createSolveColoredTilesExerciseResult();
        $this->assertEquals(100, $result->getScore());
    }
}