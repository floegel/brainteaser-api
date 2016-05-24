<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\Difficulty;
use Brainteaser\Domain\Exercise\GridSize;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesFactory
 */
class ColoredTilesFactoryTest extends UnitTest
{
    public function testBuild()
    {
        $factory = new ColoredTilesFactory();
        $coloredTiles = $factory->build(
            new Difficulty(1),
            new GridSize(4, 4)
        );

        $this->assertCount(4, $coloredTiles->getIterator());
    }
}