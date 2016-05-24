<?php
namespace Brainteaser\Application\DataTransformer;

use Brainteaser\Domain\Exercise\ColoredTiles\SolveColoredTilesExerciseResult;
use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;

class SolveColoredTilesExerciseResultDataTransformer implements DataTransformer
{
    /**
     * @param SolveColoredTilesExerciseResult $item
     * @return array
     */
    public function transform($item) : array
    {
        return [
            'correct' => $this->transformTileSet(
                $item->getCorrectTiles()
            ),
            'wrong' => $this->transformTileSet(
                $item->getWrongTiles()
            ),
            'missing' => $this->transformTileSet(
                $item->getMissingTiles()
            ),
            'score' => $item->getScore()
        ];
    }

    /**
     * @param TileSet $tileSet
     * @return array
     */
    private function transformTileSet(TileSet $tileSet) : array
    {
        $transformedTiles = [];
        /** @var Tile $tile */
        foreach ($tileSet->getIterator() as $tile) {
            $transformedTiles[] = [
                'x' => $tile->getX(),
                'y' => $tile->getY()
            ];
        }
        return $transformedTiles;
    }
}