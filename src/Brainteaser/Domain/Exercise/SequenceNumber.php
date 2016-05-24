<?php
namespace Brainteaser\Domain\Exercise;

use Brainteaser\Domain\Training\Training;
use Brainteaser\Domain\Training\TrainingAmountOfExercisesExceededException;

class SequenceNumber
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     * @throws TrainingAmountOfExercisesExceededException
     */
    public function __construct(int $value)
    {
        if ($value < 1) {
            throw new \InvalidArgumentException('SequenceNumber value');
        }

        if ($value > Training::NUM_EXERCISES) {
            throw new TrainingAmountOfExercisesExceededException;
        }
        
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return SequenceNumber
     */
    public function increase() : SequenceNumber
    {
        return new self($this->getValue() + 1);
    }
}