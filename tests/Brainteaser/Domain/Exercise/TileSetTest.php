<?php
namespace Brainteaser\Domain\Exercise;

use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\TileSet
 */
class TileSetTest extends UnitTest
{
    public function testConstruct()
    {
        $tiles = new TileSet(
            [
                new Tile(0,0),
                new Tile(1,0),
            ]
        );
        $this->assertCount(2, $tiles->getIterator());
    }

    public function testAdd()
    {
        $tiles = new TileSet();

        $tile = new Tile(0,0);
        $tiles->add($tile);

        $this->assertTrue($tiles->has($tile));
    }

    public function testAddThrowsExceptionForDuplicatedTile()
    {
        $this->expectException('\InvalidArgumentException');

        $tiles = new TileSet();

        $tile = new Tile(0,0);
        $tiles->add($tile);
        $tiles->add($tile);
    }

    public function testHas()
    {
        $tiles = new TileSet();

        $tile = new Tile(0,0);
        $this->assertFalse($tiles->has($tile));
        $tiles->add($tile);
        $this->assertTrue($tiles->has($tile));
    }

    public function testRemove()
    {
        $tiles = new TileSet();

        $tile = new Tile(0,0);
        $tiles->add($tile);
        $this->assertTrue($tiles->has($tile));
        $tiles->remove($tile);
        $this->assertFalse($tiles->has($tile));
    }

    public function testGetIterator()
    {
        $tiles = new TileSet(
            [
                new Tile(0,0)
            ]
        );
        $iterator = $tiles->getIterator();
        $this->assertInstanceOf('\ArrayIterator', $iterator);
        $this->assertCount(1, $iterator);
        $this->assertEquals('0-0', strval($iterator->current()));
    }

    /**
     * @dataProvider equalsDataProvider
     * @param TileSet $tiles
     * @param TileSet $otherTiles
     */
    public function testEquals(TileSet $tiles, TileSet $otherTiles)
    {
        $this->assertTrue($tiles->equals($otherTiles));
    }

    /**
     * @return array
     */
    public function equalsDataProvider() : array
    {
        return [
            // #0
            [
                new TileSet(
                    [
                        new Tile(0,0)
                    ]
                ),
                new TileSet(
                    [
                        new Tile(0,0)
                    ]
                )
            ],
            // #1
            [
                new TileSet(),
                new TileSet()
            ],
            // #2
            [
                new TileSet(
                    [
                        new Tile(0,0),
                        new Tile(1,0),
                        new Tile(2,0),
                        new Tile(3,0),
                    ]
                ),
                new TileSet(
                    [
                        new Tile(0,0),
                        new Tile(1,0),
                        new Tile(2,0),
                        new Tile(3,0),
                    ]
                )
            ],
        ];
    }

    /**
     * @dataProvider equalsReturnsFalseDataProvider
     * @param TileSet $tiles
     * @param TileSet $otherTiles
     */
    public function testEqualsReturnsFalse(TileSet $tiles, TileSet $otherTiles)
    {
        $this->assertFalse($tiles->equals($otherTiles));
    }

    /**
     * @return array
     */
    public function equalsReturnsFalseDataProvider() : array
    {
        return [
            // #0
            [
                new TileSet(
                    [
                        new Tile(0,0)
                    ]
                ),
                new TileSet()
            ],
            // #1
            [
                new TileSet(),
                new TileSet(
                    [
                        new Tile(0,0)
                    ]
                )
            ],
            // #2
            [
                new TileSet(
                    [
                        new Tile(0,0),
                        new Tile(1,0),
                        new Tile(2,0),
                        new Tile(3,0),
                    ]
                ),
                new TileSet(
                    [
                        new Tile(0,0),
                        new Tile(1,1),
                        new Tile(2,0),
                        new Tile(3,0),
                    ]
                )
            ],
            // #3
            [
                new TileSet(
                    [
                        new Tile(0,0),
                        new Tile(1,1),
                        new Tile(2,0),
                        new Tile(3,0),
                    ]
                ),
                new TileSet(
                    [
                        new Tile(0,0),
                        new Tile(1,0),
                        new Tile(2,0),
                        new Tile(3,0),
                    ]
                )
            ],
        ];
    }
}