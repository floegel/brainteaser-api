<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;


use Brainteaser\Domain\Exercise\Difficulty;
use Brainteaser\Domain\Exercise\GridSize;

class GridSizeFactory
{
    /**
     * @param Difficulty $difficulty
     * @return GridSize
     */
    public function build(Difficulty $difficulty) : GridSize
    {
        switch ($difficulty->getValue()) {
            case 1:
                return new GridSize(4, 4);
            case 2:
                return new GridSize(4, 4);
            case 3:
                return new GridSize(5, 4);
            case 4:
                return new GridSize(5, 4);
            case 5:
                return new GridSize(5, 5);
            case 6:
                return new GridSize(5, 5);
            case 7:
                return new GridSize(6, 5);
            case 8:
                return new GridSize(6, 5);
            case 9:
                return new GridSize(6, 6);
            case 10:
                return new GridSize(6, 6);
            case 11:
                return new GridSize(7, 6);
            case 12:
                return new GridSize(7, 6);
        }
        throw new \InvalidArgumentException('GridSizeFactory: difficulty value');
    }
}