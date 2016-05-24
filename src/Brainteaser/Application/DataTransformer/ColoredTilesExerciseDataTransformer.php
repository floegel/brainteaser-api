<?php
namespace Brainteaser\Application\DataTransformer;

use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise;
use Brainteaser\Domain\Exercise\Tile;

class ColoredTilesExerciseDataTransformer implements DataTransformer
{
    /**
     * @param ColoredTilesExercise $item
     * @return array
     */
    public function transform($item) : array
    {
        $transformedColoredTiles = [];
        /** @var Tile $tile */
        foreach ($item->getColoredTiles()->getIterator() as $tile) {
            $transformedColoredTiles[] = [
                'x' => $tile->getX(),
                'y' => $tile->getY()
            ];
        }
        return [
            'id' => $item->getId(),
            'num' => $item->getSequenceNumber()->getValue(),
            'grid_size' => [
                'rows' => $item->getGridSize()->getNumRows(),
                'cols' => $item->getGridSize()->getNumCols()
            ],
            'colored_tiles' => $transformedColoredTiles,
            'solved' => $item->isSolved()
        ];
    }
}