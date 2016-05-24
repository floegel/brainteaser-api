<?php
namespace Brainteaser\Application\Command;


use Brainteaser\Domain\Exercise\TileSet;

class SolveExerciseCommand
{
    /**
     * @var string
     */
    private $trainingId;
    
    /**
     * @var string
     */
    private $exerciseId;

    /**
     * @var TileSet
     */
    private $solutionTileSet;

    /**
     * @param string $trainingId
     * @param string $exerciseId
     * @param TileSet $solutionTileSet
     */
    public function __construct(
        string $trainingId,
        string $exerciseId,
        TileSet $solutionTileSet
    ) {
        $this->trainingId = $trainingId;
        $this->exerciseId = $exerciseId;
        $this->solutionTileSet = $solutionTileSet;
    }

    /**
     * @return string
     */
    public function getTrainingId() : string
    {
        return $this->trainingId;
    }

    /**
     * @return string
     */
    public function getExerciseId() : string
    {
        return $this->exerciseId;
    }

    /**
     * @return TileSet
     */
    public function getSolutionTileSet() : TileSet
    {
        return $this->solutionTileSet;
    }
}