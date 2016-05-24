<?php
namespace Brainteaser\Application\DataTransformer;

use Brainteaser\Domain\Fixture\Exercise\ColoredTiles\ColoredTilesExerciseFixture;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Application\DataTransformer\ColoredTilesExerciseDataTransformer
 */
class ColoredTilesExerciseDataTransformerTest extends UnitTest
{
    public function testTransform()
    {
        $item = ColoredTilesExerciseFixture::getUnsolved();
        $dataTransformer = new ColoredTilesExerciseDataTransformer();

        $expectedData = [
            'id' => 'xy',
            'num' => 1,
            'grid_size' => [
                'rows' => 4,
                'cols' => 4
            ],
            'colored_tiles' => [
                [
                    'x' => 0, 'y' => 0
                ],
                [
                    'x' => 1, 'y' => 0
                ],
                [
                    'x' => 2, 'y' => 0
                ],
                [
                    'x' => 3, 'y' => 0
                ],
            ],
            'solved' => false
        ];

        $this->assertEquals(
            $expectedData,
            $dataTransformer->transform($item)
        );
    }
}