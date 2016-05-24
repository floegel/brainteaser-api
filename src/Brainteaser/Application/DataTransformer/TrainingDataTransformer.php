<?php
namespace Brainteaser\Application\DataTransformer;

use Brainteaser\Domain\Training\Training;

class TrainingDataTransformer implements DataTransformer
{
    /**
     * @param Training $item
     * @return array
     */
    public function transform($item) : array
    {
        return [
            'id' => $item->getId(),
            'score' => $item->getScore(),
            'num_exercises' => $item->getNumExercises()
        ];
    }
}