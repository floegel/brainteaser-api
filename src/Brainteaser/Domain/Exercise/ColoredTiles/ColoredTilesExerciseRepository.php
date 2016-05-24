<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\ExerciseDoesNotExistException;

interface ColoredTilesExerciseRepository
{
    /**
     * @param string $coloredTilesExerciseId
     * @param string $trainingId
     * @return ColoredTilesExercise
     * @throws ExerciseDoesNotExistException
     */
    public function get(string $coloredTilesExerciseId, string $trainingId) : ColoredTilesExercise;

    /**
     * @param string $trainingId
     * @return ColoredTilesExercise[]
     */
    public function findLastTwo(string $trainingId) : array;

    /**
     * @param ColoredTilesExercise $coloredTilesExercise
     */
    public function add(ColoredTilesExercise $coloredTilesExercise);
}