<?php
namespace Brainteaser\Application\CommandHandler;

use Brainteaser\Application\Command\StartExerciseCommand;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseFactory;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseRepository;
use Brainteaser\Domain\Training\TrainingRepository;
use Mockery;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Application\CommandHandler\StartExerciseCommandHandler
 */
class StartExerciseCommandHandlerTest extends UnitTest
{
    /**
     * @param Mockery\Mock|ColoredTilesExercise $exerciseMock
     * @param bool $trainingIsFinished
     * @return StartExerciseCommandHandler
     */
    private function createCommandHandler(
        $exerciseMock,
        bool $trainingIsFinished = false
    ) : StartExerciseCommandHandler
    {
        $trainingMock = Mockery::mock('\Brainteaser\Domain\Training\Training', [
            'getId' => 'xy',
            'isFinished' => $trainingIsFinished
        ]);

        /** @var Mockery\Mock|TrainingRepository $trainingRepository */
        $trainingRepository = Mockery::mock('\Brainteaser\Domain\Training\TrainingRepository');
        $trainingRepository->shouldReceive('get')
            ->withArgs(['xy'])
            ->once()
            ->andReturn($trainingMock);

        $lastExercise = clone $exerciseMock;
        $secondToLastExercise = clone $lastExercise;
        /** @var Mockery\Mock|ColoredTilesExerciseRepository $exerciseRepository */
        $exerciseRepository = Mockery::mock('\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseRepository');
        $exerciseRepository->shouldReceive('findLastTwo')
            ->withArgs(['xy'])
            ->once()
            ->andReturn([$lastExercise, $secondToLastExercise]);
        $exerciseRepository->shouldReceive('add')
            ->withArgs([$exerciseMock])
            ->once();

        /** @var Mockery\Mock|ColoredTilesExerciseFactory $exerciseFactory */
        $exerciseFactory = Mockery::mock('\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseFactory');
        $exerciseFactory->shouldReceive('build')
            ->withArgs([$trainingMock, $lastExercise, $secondToLastExercise])
            ->once()
            ->andReturn($exerciseMock);

        return new StartExerciseCommandHandler(
            $trainingRepository,
            $exerciseFactory,
            $exerciseRepository
        );
    }

    public function testHandle()
    {
        /** @var Mockery\Mock|ColoredTilesExercise $exerciseMock */
        $exerciseMock = Mockery::mock('\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise');
        $commandHandler = $this->createCommandHandler($exerciseMock);
        $exercise = $commandHandler->handle(
            new StartExerciseCommand('xy')
        );
        $this->assertEquals($exerciseMock, $exercise);
    }

    public function testHandleThrowsExceptionIfTrainingIsFinished()
    {
        $this->expectException('\Brainteaser\Domain\Training\TrainingAlreadyFinishedException');
        /** @var Mockery\Mock|ColoredTilesExercise $exerciseMock */
        $exerciseMock = Mockery::mock('\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise');
        $commandHandler = $this->createCommandHandler($exerciseMock, true);
        $commandHandler->handle(
            new StartExerciseCommand('xy')
        );
    }
}