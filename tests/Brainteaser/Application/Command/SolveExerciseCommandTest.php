<?php
namespace Brainteaser\Application\Command;

use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Application\Command\SolveExerciseCommand
 */
class SolveExerciseCommandTest extends UnitTest
{
    /**
     * @return SolveExerciseCommand
     */
    private function createSolveExerciseCommand() : SolveExerciseCommand
    {
        return new SolveExerciseCommand(
            'xy',
            'yz',
            new TileSet(
                [
                    new Tile(0, 0),
                    new Tile(1, 0),
                    new Tile(2, 0),
                    new Tile(3, 0),
                ]
            )
        );
    }

    public function testGetTrainingId()
    {
        $command = $this->createSolveExerciseCommand();
        $this->assertEquals('xy', $command->getTrainingId());
    }

    public function testGetExerciseId()
    {
        $command = $this->createSolveExerciseCommand();
        $this->assertEquals('yz', $command->getExerciseId());
    }

    public function testGetSolutionTileSet()
    {
        $command = $this->createSolveExerciseCommand();
        $expectedTiles = new TileSet(
            [
                new Tile(0, 0),
                new Tile(1, 0),
                new Tile(2, 0),
                new Tile(3, 0),
            ]
        );
        $this->assertTrue($expectedTiles->equals($command->getSolutionTileSet()));
    }
}