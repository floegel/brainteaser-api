<?php
namespace Brainteaser\Domain\Exercise;

use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\GridSize
 */
class GridSizeTest extends UnitTest
{
    public function testGetNumRows()
    {
        $gridSize = new GridSize(4,5);
        $this->assertEquals(4, $gridSize->getNumRows());
    }

    public function testGetNumCols()
    {
        $gridSize = new GridSize(4,5);
        $this->assertEquals(5, $gridSize->getNumCols());
    }

    public function testCountTiles()
    {
        $gridSize = new GridSize(4,5);
        $this->assertEquals(20, $gridSize->countTiles());
    }
}