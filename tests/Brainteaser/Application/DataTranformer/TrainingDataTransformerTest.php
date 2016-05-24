<?php
namespace Brainteaser\Application\DataTransformer;

use Brainteaser\Domain\Training\Training;
use DateTime;
use PHPUnit_Framework_TestCase as UnitTest;

/**
 * @covers \Brainteaser\Application\DataTransformer\TrainingDataTransformer
 */
class TrainingDataTransformerTest extends UnitTest
{
    public function testTransform()
    {
        $item = new Training(
            'xy',
            new DateTime(),
            null,
            400
        );
        $dataTransformer = new TrainingDataTransformer();

        $expectedData = [
            'id' => 'xy',
            'score' => 400,
            'num_exercises' => 12
        ];
        
        $this->assertEquals(
            $expectedData,
            $dataTransformer->transform($item)
        );
    }
}