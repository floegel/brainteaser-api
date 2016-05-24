<?php
namespace Brainteaser\Domain\Exercise;

use Brainteaser\Domain\Training\Training;
use DateTime;

interface Exercise
{
    /**
     * @return string
     */
    public function getId() : string;

    /**
     * @return Training
     */
    public function getTraining() : Training;

    /**
     * @return SequenceNumber
     */
    public function getSequenceNumber() : SequenceNumber;

    /**
     * @return GridSize
     */
    public function getGridSize() : GridSize;

    /**
     * @return DateTime
     */
    public function getStartedAt();

    /**
     * @return Difficulty
     */
    public function getDifficulty() : Difficulty;

    /**
     * @return int|null
     */
    public function getSolutionAccuracy();

    /**
     * @return bool
     */
    public function isSolved() : bool;

    /**
     * @return bool
     */
    public function isSolvedPerfectly() : bool;
}