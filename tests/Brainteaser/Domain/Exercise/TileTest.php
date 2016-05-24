<?php
namespace Brainteaser\Domain\Exercise;

use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\Tile
 */
class TileTest extends UnitTest
{
    public function testGetX()
    {
        $tile = new Tile(0,1);
        $this->assertEquals(0, $tile->getX());
    }

    public function testGetY()
    {
        $tile = new Tile(0,1);
        $this->assertEquals(1, $tile->getY());
    }

    public function test__toString()
    {
        $tile = new Tile(0,1);
        $this->assertEquals('0-1', strval($tile));
    }
}