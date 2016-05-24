<?php
namespace Brainteaser\Application\CommandHandler;

use Brainteaser\Domain\Training\TrainingFactory;
use Brainteaser\Domain\Training\TrainingRepository;
use Mockery;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Application\CommandHandler\StartTrainingCommandHandler
 */
class StartTrainingCommandHandlerTest extends UnitTest
{
    public function testHandle()
    {
        $trainingMock = Mockery::mock('\Brainteaser\Domain\Training\Training', [
            'getId' => 'xy'
        ]);
        /** @var Mockery\Mock|TrainingFactory $trainingFactory */
        $trainingFactory = Mockery::mock('\Brainteaser\Domain\Training\TrainingFactory');
        $trainingFactory->shouldReceive('build')
            ->once()
            ->andReturn($trainingMock);
        /** @var Mockery\Mock|TrainingRepository $trainingRepository */
        $trainingRepository = Mockery::mock('\Brainteaser\Domain\Training\TrainingRepository');
        $trainingRepository->shouldReceive('add')
            ->once()
            ->withArgs([$trainingMock]);
        $commandHandler = new StartTrainingCommandHandler(
            $trainingFactory,
            $trainingRepository
        );
        $training = $commandHandler->handle();
        $this->assertEquals($trainingMock, $training);
    }
}