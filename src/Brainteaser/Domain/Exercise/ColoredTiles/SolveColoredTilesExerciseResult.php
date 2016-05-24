<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\TileSet;

class SolveColoredTilesExerciseResult
{
    /**
     * @var TileSet
     */
    private $correctTiles;

    /**
     * @var TileSet
     */
    private $wrongTiles;

    /**
     * @var TileSet
     */
    private $missingTiles;

    /**
     * @var int
     */
    private $score;

    /**
     * @param TileSet $correctTiles
     * @param TileSet $wrongTiles
     * @param TileSet $missingTiles
     * @param int $score
     */
    public function __construct(
        TileSet $correctTiles,
        TileSet $wrongTiles,
        TileSet $missingTiles,
        int $score
    ) {
        $this->correctTiles = $correctTiles;
        $this->wrongTiles = $wrongTiles;
        $this->missingTiles = $missingTiles;
        $this->score = $score;
    }

    /**
     * @return TileSet
     */
    public function getCorrectTiles() : TileSet
    {
        return $this->correctTiles;
    }

    /**
     * @return TileSet
     */
    public function getWrongTiles() : TileSet
    {
        return $this->wrongTiles;
    }

    /**
     * @return TileSet
     */
    public function getMissingTiles() : TileSet
    {
        return $this->missingTiles;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }
}