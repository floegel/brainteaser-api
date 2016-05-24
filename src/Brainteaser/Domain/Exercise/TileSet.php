<?php
namespace Brainteaser\Domain\Exercise;

use ArrayIterator;

class TileSet
{
    /**
     * @var Tile[]
     */
    private $tileDictionary = [];

    /**
     * @param Tile[] $tiles
     */
    public function __construct(array $tiles = [])
    {
        foreach ($tiles as $tile) {
            $this->add($tile);
        }
    }

    /**
     * @param Tile $tile
     */
    public function add(Tile $tile)
    {
        if ($this->has($tile)) {
            throw new \InvalidArgumentException('Tile already part of the set');
        }
        $this->tileDictionary[strval($tile)] = $tile;
    }

    /**
     * @param Tile $tile
     * @return bool
     */
    public function has(Tile $tile) : bool
    {
        return array_key_exists(strval($tile), $this->tileDictionary);
    }

    /**
     * @param Tile $tile
     */
    public function remove(Tile $tile)
    {
        if ($this->has($tile)) {
            unset($this->tileDictionary[strval($tile)]);
        }
    }
    
    /**
     * @return ArrayIterator
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->tileDictionary);
    }

    /**
     * @param TileSet $otherTileSet
     * @return bool
     */
    public function equals(TileSet $otherTileSet) : bool
    {
        return $this->getIterator()->getArrayCopy() == $otherTileSet->getIterator()->getArrayCopy();
    }
}