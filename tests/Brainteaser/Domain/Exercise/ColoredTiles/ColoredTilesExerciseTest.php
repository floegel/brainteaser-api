<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\Difficulty;
use Brainteaser\Domain\Exercise\GridSize;
use Brainteaser\Domain\Exercise\SequenceNumber;
use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;
use Brainteaser\Domain\Training\Training;
use PHPUnit_Framework_TestCase as UnitTest;
use \DateTime;

/**
 * @covers \Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExercise
 */
class ColoredTilesExerciseTest extends UnitTest
{
    /**
     * @param DateTime|null $solvedAt
     * @param int|null $solutionAccuracy
     * @param int $sequenceNumber
     * @return ColoredTilesExercise
     */
    private function createExercise(
        $solvedAt = null,
        $solutionAccuracy = null,
        int $sequenceNumber = 1
    ) {
        return new ColoredTilesExercise(
            'xy',
            new SequenceNumber($sequenceNumber),
            new Training(
                'tr',
                new DateTime
            ),
            new Difficulty(1),
            new GridSize(4,4),
            new TileSet(
                [
                    new Tile(0,0),
                    new Tile(1,0),
                    new Tile(2,0),
                    new Tile(3,0),
                ]
            ),
            new DateTime('2016-05-01 18:00:00'),
            $solvedAt,
            $solutionAccuracy
        );
    }

    public function testGetId()
    {
        $exercise = $this->createExercise();
        $this->assertEquals('xy', $exercise->getId());
    }

    public function testGetSequenceNumber()
    {
        $exercise = $this->createExercise();
        $this->assertEquals(1, $exercise->getSequenceNumber()->getValue());
    }

    public function testGetTraining()
    {
        $exercise = $this->createExercise();
        $this->assertEquals('tr', $exercise->getTraining()->getId());
    }

    public function testGetGridSize()
    {
        $exercise = $this->createExercise();
        $this->assertEquals(4, $exercise->getGridSize()->getNumRows());
        $this->assertEquals(4, $exercise->getGridSize()->getNumCols());
    }

    public function testGetColoredTiles()
    {
        $exercise = $this->createExercise();
        $this->assertCount(4, $exercise->getColoredTiles()->getIterator());
    }

    public function testGetStartedAt()
    {
        $exercise = $this->createExercise();
        $this->assertEquals(
            $exercise->getStartedAt(),
            new DateTime('2016-05-01 18:00:00')
        );
    }

    public function testGetDifficulty()
    {
        $exercise = $this->createExercise();
        $this->assertEquals(1, $exercise->getDifficulty()->getValue());
    }

    public function testGetSolutionAccuracy()
    {
        $exercise = $this->createExercise(
            new DateTime('2016-05-01 18:00:05'),
            80
        );
        $this->assertEquals(80, $exercise->getSolutionAccuracy());
    }

    public function testGetSolutionAccuracyShouldReturnNull()
    {
        $exercise = $this->createExercise();
        $this->assertNull($exercise->getSolutionAccuracy());
    }

    public function testIsSolved()
    {
        $exercise = $this->createExercise();
        $this->assertFalse($exercise->isSolved());
    }

    public function testIsSolvedShouldReturnTrue()
    {
        $exercise = $this->createExercise(
            new DateTime('2016-05-01 18:00:05'),
            80
        );
        $this->assertTrue($exercise->isSolved());
    }

    public function testIsSolvedPerfectly()
    {
        $exercise = $this->createExercise();
        $this->assertFalse($exercise->isSolvedPerfectly());
    }

    public function testIsSolvedPerfectlyShouldReturnTrue()
    {
        $exercise = $this->createExercise(
            new DateTime('2016-05-01 18:00:05'),
            100
        );
        $this->assertTrue($exercise->isSolvedPerfectly());
    }

    public function testSolveThrowsExceptionWhenAlreadySolved()
    {
        $this->expectException('\Brainteaser\Domain\Exercise\ExerciseAlreadySolvedException');
        $exercise = $this->createExercise(
            new DateTime('2016-05-01 18:00:05'),
            100
        );
        $exercise->solve(
            new TileSet(
                [
                    new Tile(0,0),
                    new Tile(1,0),
                    new Tile(2,0),
                    new Tile(3,0),
                ]
            )
        );
    }

    public function testSolveThrowsExceptionWhenSolutionHasInvalidNumberOfTiles()
    {
        $this->expectException('\Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseSolutionHasInvalidNumberOfTilesException');
        $exercise = $this->createExercise();
        $exercise->solve(
            new TileSet()
        );
    }

    public function testSolve()
    {
        $exercise = $this->createExercise();

        $solutionTiles = new TileSet(
            [
                new Tile(0, 0),
                new Tile(1, 0),
                new Tile(2, 0),
                new Tile(3, 0),
            ]
        );
        $result = $exercise->solve($solutionTiles);
        $noTiles = new TileSet();

        $this->assertEquals(400, $result->getScore());
        $this->assertTrue($result->getCorrectTiles()->equals($solutionTiles));
        $this->assertTrue($result->getWrongTiles()->equals($noTiles));
        $this->assertTrue($result->getMissingTiles()->equals($noTiles));
    }

    public function testSolveIncreasesTrainingScore()
    {
        $exercise = $this->createExercise();

        $solutionTiles = new TileSet(
            [
                new Tile(0, 0),
                new Tile(1, 0),
                new Tile(2, 0),
                new Tile(3, 0),
            ]
        );
        $exercise->solve($solutionTiles);

        $this->assertEquals(400, $exercise->getTraining()->getScore());
    }

    public function testSolveMarksExerciseAsSolved()
    {
        $exercise = $this->createExercise();

        $solutionTiles = new TileSet(
            [
                new Tile(0, 0),
                new Tile(1, 0),
                new Tile(2, 0),
                new Tile(3, 0),
            ]
        );
        $exercise->solve($solutionTiles);

        $this->assertTrue($exercise->isSolved());
        $this->assertTrue($exercise->isSolvedPerfectly());
    }

    public function testSolveSetsSolutionAccuracy()
    {
        $exercise = $this->createExercise();

        $solutionTiles = new TileSet(
            [
                new Tile(0, 0),
                new Tile(1, 0),
                new Tile(2, 2), // wrong
                new Tile(3, 2), // wrong
            ]
        );
        $exercise->solve($solutionTiles);

        $this->assertEquals(50, $exercise->getSolutionAccuracy());
    }

    public function testSolveWithMissingAndWrongTiles()
    {
        $exercise = $this->createExercise();

        // missing: 2-0, 3-0
        $solutionTiles = new TileSet(
            [
                new Tile(0, 0),
                new Tile(1, 0),
                new Tile(2, 2), // wrong
                new Tile(3, 2), // wrong
            ]
        );
        $result = $exercise->solve($solutionTiles);
        $correctTiles = new TileSet(
            [
                new Tile(0, 0),
                new Tile(1, 0),
            ]
        );
        $missingTiles = new TileSet(
            [
                new Tile(2, 0),
                new Tile(3, 0),
            ]
        );
        $wrongTiles = new TileSet(
            [
                new Tile(2, 2),
                new Tile(3, 2),
            ]
        );
        $this->assertEquals(200, $result->getScore());
        $this->assertTrue($result->getCorrectTiles()->equals($correctTiles));
        $this->assertTrue($result->getWrongTiles()->equals($wrongTiles));
        $this->assertTrue($result->getMissingTiles()->equals($missingTiles));
    }

    public function testSolveMarksTrainingAsFinishedForSequenceNumber12()
    {
        $exercise = $this->createExercise(null, null, 12);

        $solutionTiles = new TileSet(
            [
                new Tile(0, 0),
                new Tile(1, 0),
                new Tile(2, 0),
                new Tile(3, 0),
            ]
        );
        $exercise->solve($solutionTiles);
        $this->assertTrue($exercise->getTraining()->isFinished());
    }

    public function testSolveDoesNotMarkTrainingAsFinishedForSequenceNumberOtherThan12()
    {
        $exercise = $this->createExercise();

        $solutionTiles = new TileSet(
            [
                new Tile(0, 0),
                new Tile(1, 0),
                new Tile(2, 0),
                new Tile(3, 0),
            ]
        );
        $exercise->solve($solutionTiles);
        $this->assertFalse($exercise->getTraining()->isFinished());
    }
}