<?php
namespace Brainteaser\Application\CommandHandler;

use Brainteaser\Application\Command\StartExerciseCommand;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseFactory;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseRepository;
use Brainteaser\Domain\Exercise\Exercise;
use Brainteaser\Domain\Training\TrainingAlreadyFinishedException;
use Brainteaser\Domain\Training\TrainingRepository;

class StartExerciseCommandHandler
{
    /**
     * @var TrainingRepository
     */
    private $trainingRepository;

    /**
     * @var ColoredTilesExerciseFactory
     */
    private $exerciseFactory;

    /**
     * @var ColoredTilesExerciseRepository
     */
    private $exerciseRepository;

    /**
     * @param TrainingRepository $trainingRepository
     * @param ColoredTilesExerciseFactory $exerciseFactory
     * @param ColoredTilesExerciseRepository $exerciseRepository
     */
    public function __construct(
        TrainingRepository $trainingRepository,
        ColoredTilesExerciseFactory $exerciseFactory,
        ColoredTilesExerciseRepository $exerciseRepository
    ) {
        $this->trainingRepository = $trainingRepository;
        $this->exerciseFactory = $exerciseFactory;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * @param StartExerciseCommand $command
     * @return Exercise
     * @throws TrainingAlreadyFinishedException
     */
    public function handle(StartExerciseCommand $command)
    {
        $training = $this->trainingRepository->get(
            $command->getTrainingId()
        );

        if ($training->isFinished()) {
            throw new TrainingAlreadyFinishedException;
        }

        $lastExercises = $this->exerciseRepository->findLastTwo(
            $command->getTrainingId()
        );

        $exercise = $this->exerciseFactory->build(
            $training,
            array_shift($lastExercises),
            array_shift($lastExercises)
        );

        $this->exerciseRepository->add($exercise);

        return $exercise;
    }
}
