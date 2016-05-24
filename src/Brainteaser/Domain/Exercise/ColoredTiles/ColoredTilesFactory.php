<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;


use Brainteaser\Domain\Exercise\Difficulty;
use Brainteaser\Domain\Exercise\GridSize;
use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;

class ColoredTilesFactory
{
    /**
     * @param Difficulty $difficulty
     * @param GridSize $gridSize
     * @return TileSet
     */
    public function build(Difficulty $difficulty, GridSize $gridSize) : TileSet
    {
        $numColoredTiles = $difficulty->getValue() + 3;
        $numTiles = $gridSize->countTiles();

        $numbers = range(1, $numTiles);
        shuffle($numbers);
        $coloredTileNumbers = array_slice($numbers, 0, $numColoredTiles);

        $coloredTiles = array_map(function($n) use ($gridSize) {
            $x = ($n-1) % $gridSize->getNumCols();
            $y = intval(floor(($n-1) / $gridSize->getNumCols()));
            return new Tile($x, $y);
        }, $coloredTileNumbers);

        return new TileSet($coloredTiles);
    }
}