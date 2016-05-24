<?php
namespace Brainteaser\Application\CommandHandler;

use Brainteaser\Application\Command\SolveExerciseCommand;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseRepository;
use Brainteaser\Domain\Exercise\ColoredTiles\SolveColoredTilesExerciseResult;
use Brainteaser\Domain\Exercise\ExerciseDoesNotExistException;
use Brainteaser\Domain\Training\TrainingRepository;

class SolveExerciseCommandHandler
{
    /**
     * @var ColoredTilesExerciseRepository
     */
    private $exerciseRepository;

    /**
     * @var TrainingRepository
     */
    private $trainingRepository;

    /**
     * @param TrainingRepository $trainingRepository
     * @param ColoredTilesExerciseRepository $exerciseRepository
     */
    public function __construct(
        TrainingRepository $trainingRepository,
        ColoredTilesExerciseRepository $exerciseRepository
    ) {
        $this->trainingRepository = $trainingRepository;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * @param SolveExerciseCommand $command
     * @return SolveColoredTilesExerciseResult
     * @throws ExerciseDoesNotExistException
     */
    public function handle(SolveExerciseCommand $command)
    {
        $exercise = $this->exerciseRepository->get(
            $command->getExerciseId(),
            $command->getTrainingId()
        );

        $result = $exercise->solve(
            $command->getSolutionTileSet()
        );

        $this->trainingRepository->add($exercise->getTraining());
        $this->exerciseRepository->add($exercise);

        return $result;
    }
}
