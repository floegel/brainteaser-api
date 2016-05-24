<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\Difficulty;
use Mockery;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Domain\Exercise\ColoredTiles\GridSizeFactory
 */
class GridSizeFactoryTest extends UnitTest
{
    /**
     * @dataProvider buildProvider
     * @param int $difficultyValue
     * @param int $expectedNumRows
     * @param int $expectedNumCols
     */
    public function testBuild(int $difficultyValue, int $expectedNumRows, int $expectedNumCols)
    {
        $factory = new GridSizeFactory();
        $gridSize = $factory->build(new Difficulty($difficultyValue));
        $this->assertEquals($expectedNumRows, $gridSize->getNumRows());
        $this->assertEquals($expectedNumCols, $gridSize->getNumCols());
    }

    /**
     * @return array
     */
    public function buildProvider() : array
    {
        return [
            [1, 4, 4],
            [2, 4, 4],
            [3, 5, 4],
            [4, 5, 4],
            [5, 5, 5],
            [6, 5, 5],
            [7, 6, 5],
            [8, 6, 5],
            [9, 6, 6],
            [10, 6, 6],
            [11, 7, 6],
            [12, 7, 6],
        ];
    }

    public function testBuildThrowsExceptionOnInvalidDifficulty()
    {
        $this->expectException('\InvalidArgumentException');
        // as difficulty is a self-validating value object its not possible to create one with an invalid value,
        // so we mock one
        /** @var Mockery\Mock|Difficulty $difficulty */
        $difficulty = Mockery::mock('\Brainteaser\Domain\Exercise\Difficulty', [
            'getValue' => 99
        ]);
        $factory = new GridSizeFactory();
        $factory->build($difficulty);
    }
}