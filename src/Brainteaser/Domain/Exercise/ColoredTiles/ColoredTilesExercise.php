<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\Difficulty;
use Brainteaser\Domain\Exercise\Exercise;
use Brainteaser\Domain\Exercise\ExerciseAlreadySolvedException;
use Brainteaser\Domain\Exercise\GridSize;
use Brainteaser\Domain\Exercise\SequenceNumber;
use Brainteaser\Domain\Exercise\TileSet;
use Brainteaser\Domain\Training\Training;
use DateTime;

class ColoredTilesExercise implements Exercise
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var SequenceNumber
     */
    private $sequenceNumber;

    /**
     * @var Training
     */
    private $training;

    /**
     * @var GridSize
     */
    private $gridSize;

    /**
     * @var TileSet
     */
    private $coloredTiles;

    /**
     * @var DateTime
     */
    private $startedAt;

    /**
     * @var DateTime
     */
    private $solvedAt;

    /**
     * @var Difficulty
     */
    private $difficulty;

    /**
     * @var int|null
     */
    private $solutionAccuracy;

    /**
     * @param string $id
     * @param SequenceNumber $sequenceNumber
     * @param Training $training
     * @param Difficulty $difficulty
     * @param GridSize $gridSize
     * @param TileSet $coloredTiles
     * @param DateTime $startedAt
     * @param DateTime|null $solvedAt
     * @param int|null $solutionAccuracy
     */
    public function __construct(
        string $id,
        SequenceNumber $sequenceNumber,
        Training $training,
        Difficulty $difficulty,
        GridSize $gridSize,
        TileSet $coloredTiles,
        DateTime $startedAt,
        DateTime $solvedAt = null,
        int $solutionAccuracy = null
    ) {
        $this->id = $id;
        $this->sequenceNumber = $sequenceNumber;
        $this->training = $training;
        $this->gridSize = $gridSize;
        $this->coloredTiles = $coloredTiles;
        $this->startedAt = $startedAt;
        $this->solvedAt = $solvedAt;
        $this->difficulty = $difficulty;
        $this->solutionAccuracy = $solutionAccuracy;
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return SequenceNumber
     */
    public function getSequenceNumber() : SequenceNumber
    {
        return $this->sequenceNumber;
    }

    /**
     * @return Training
     */
    public function getTraining() : Training
    {
        return $this->training;
    }

    /**
     * @return GridSize
     */
    public function getGridSize() : GridSize
    {
        return $this->gridSize;
    }

    /**
     * @return TileSet
     */
    public function getColoredTiles() : TileSet
    {
        return $this->coloredTiles;
    }

    /**
     * @return DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }
    
    /**
     * @return Difficulty
     */
    public function getDifficulty() : Difficulty
    {
        return $this->difficulty;
    }

    /**
     * @return int|null
     */
    public function getSolutionAccuracy()
    {
        return $this->solutionAccuracy;
    }

    /**
     * @return bool
     */
    public function isSolved() : bool
    {
        return !is_null($this->solvedAt);
    }

    /**
     * @return bool
     */
    public function isSolvedPerfectly() : bool
    {
        return ($this->isSolved() && $this->solutionAccuracy == 100);
    }

    /**
     * @param TileSet $solutionTiles
     * @return SolveColoredTilesExerciseResult
     * @throws ColoredTilesExerciseSolutionHasInvalidNumberOfTilesException
     * @throws ExerciseAlreadySolvedException
     */
    public function solve(TileSet $solutionTiles) : SolveColoredTilesExerciseResult
    {
        if ($this->isSolved()) {
            throw new ExerciseAlreadySolvedException;
        }

        if (count($solutionTiles->getIterator()) != count($this->getColoredTiles()->getIterator())) {
            throw new ColoredTilesExerciseSolutionHasInvalidNumberOfTilesException;
        }

        $remainingColoredTiles = clone($this->getColoredTiles());

        // correct, wrong, missing
        $correctTiles = new TileSet;
        $wrongTiles = new TileSet;
        foreach ($solutionTiles->getIterator() as $tile) {
            if ($remainingColoredTiles->has($tile)) {
                $correctTiles->add($tile);
                $remainingColoredTiles->remove($tile);
                continue;
            }
            $wrongTiles->add($tile);
        }

        $this->solvedAt = new DateTime;
        $this->solutionAccuracy = intval(
            count($correctTiles->getIterator()) * 100 / count($this->getColoredTiles()->getIterator())
        );
        
        $training = $this->getTraining();
        if ($this->getSequenceNumber()->getValue() == $training->getNumExercises()) {
            $training->markAsFinished();
        }

        $score = count($correctTiles->getIterator()) * 100;
        $training->increaseScore($score);

        return new SolveColoredTilesExerciseResult(
            $correctTiles,
            $wrongTiles,
            $remainingColoredTiles,
            $score
        );
    }
}