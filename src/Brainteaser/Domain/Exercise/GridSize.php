<?php
namespace Brainteaser\Domain\Exercise;

class GridSize
{
    /**
     * @var int
     */
    private $numRows;

    /**
     * @var int
     */
    private $numCols;

    /**
     * @param int $numRows
     * @param int $numCols
     */
    public function __construct(int $numRows, int $numCols)
    {
        $this->numRows = $numRows;
        $this->numCols = $numCols;
    }

    /**
     * @return int
     */
    public function getNumRows() : int
    {
        return $this->numRows;
    }

    /**
     * @return int
     */
    public function getNumCols() : int
    {
        return $this->numCols;
    }

    /**
     * @return int
     */
    public function countTiles()
    {
        return $this->getNumRows() * $this->getNumCols();
    }
}