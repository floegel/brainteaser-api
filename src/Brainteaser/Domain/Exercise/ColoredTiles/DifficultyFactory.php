<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;


use Brainteaser\Domain\Exercise\Difficulty;
use Brainteaser\Domain\Exercise\PreviousUnsolvedExerciseException;

class DifficultyFactory
{
    /**
     * @param ColoredTilesExercise|null $lastExercise
     * @param ColoredTilesExercise|null $secondToLastExercise
     * @return Difficulty
     */
    public function build(
        ColoredTilesExercise $lastExercise = null,
        ColoredTilesExercise $secondToLastExercise = null
    ) {
        $this->validateExercises($lastExercise, $secondToLastExercise);

        // no previous exercise is given, start with 1
        if (is_null($lastExercise) && is_null($secondToLastExercise)) {
            return new Difficulty(1);
        }

        // this makes no sense
        if (is_null($lastExercise) && !is_null($secondToLastExercise)) {
            throw new \InvalidArgumentException(
                'DifficultyFactory: secondToLastExercise given, but no lastExercise given'
            );
        }

        // only last exercise is given
        if (!is_null($lastExercise) && is_null($secondToLastExercise)) {
            return $this->buildBasedOnLastExerciseOnly($lastExercise);
        }

        // both exercises are given
        if (!$lastExercise->isSolvedPerfectly() && !$secondToLastExercise->isSolvedPerfectly()) {
            return $lastExercise->getDifficulty()->decrease();
        }

        return $this->buildBasedOnLastExerciseOnly($lastExercise);
    }

    /**
     * @param ColoredTilesExercise $lastExercise
     * @return Difficulty
     */
    private function buildBasedOnLastExerciseOnly(
        ColoredTilesExercise $lastExercise
    ) {
        if ($lastExercise->isSolvedPerfectly()) {
            return $lastExercise->getDifficulty()->increase();
        }
        return $lastExercise->getDifficulty();
    }

    /**
     * We expect the exercises to be solved
     *
     * @param ColoredTilesExercise|null $lastExercise
     * @param ColoredTilesExercise|null $secondToLastExercise
     * @throws PreviousUnsolvedExerciseException
     */
    private function validateExercises(
        ColoredTilesExercise $lastExercise = null,
        ColoredTilesExercise $secondToLastExercise = null
    ) {
        if (!is_null($lastExercise) && !$lastExercise->isSolved()) {
            throw new PreviousUnsolvedExerciseException;
        }

        // this should never happen
        if (!is_null($secondToLastExercise) && !$secondToLastExercise->isSolved()) {
            throw new PreviousUnsolvedExerciseException;
        }
    }
}