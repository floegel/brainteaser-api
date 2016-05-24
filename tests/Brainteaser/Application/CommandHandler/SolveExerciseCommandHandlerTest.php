<?php
namespace Brainteaser\Application\CommandHandler;

use Brainteaser\Application\Command\SolveExerciseCommand;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseRepository;
use Brainteaser\Domain\Exercise\TileSet;
use Brainteaser\Domain\Training\TrainingRepository;
use Mockery;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Application\CommandHandler\SolveExerciseCommandHandler
 */
class SolveExerciseCommandHandlerTest extends UnitTest
{
    public function testHandle()
    {
        $trainingMock = Mockery::mock('\Brainteaser\Domain\Training\Training');
        $solveColoredTilesExerciseResultMock = Mockery::mock(
            '\Brainteaser\Domain\Exercise\ColoredTiles\SolveColoredTilesExerciseResult'
        );
        $exerciseMock = Mockery::mock('\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise', [
            'getTraining' => $trainingMock,
            'solve' => $solveColoredTilesExerciseResultMock
        ]);

        /** @var Mockery\Mock|TrainingRepository $trainingRepository */
        $trainingRepository = Mockery::mock('\Brainteaser\Domain\Training\TrainingRepository');
        $trainingRepository->shouldReceive('add')
            ->withArgs([$trainingMock])
            ->once();

        /** @var Mockery\Mock|ColoredTilesExerciseRepository $exerciseRepository */
        $exerciseRepository = Mockery::mock('\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseRepository');
        $exerciseRepository->shouldReceive('get')
            ->withArgs(['yz', 'xy'])
            ->once()
            ->andReturn($exerciseMock);
        $exerciseRepository->shouldReceive('add')
            ->withArgs([$exerciseMock])
            ->once();

        $commandHandler = new SolveExerciseCommandHandler(
            $trainingRepository,
            $exerciseRepository
        );
        /** @var Mockery\Mock|TileSet $solutionTilesMock */
        $solutionTilesMock = Mockery::mock('\Brainteaser\Domain\Exercise\TileSet');
        $result = $commandHandler->handle(
            new SolveExerciseCommand('xy', 'yz', $solutionTilesMock)
        );
        $this->assertEquals($solveColoredTilesExerciseResultMock, $result);
    }
}