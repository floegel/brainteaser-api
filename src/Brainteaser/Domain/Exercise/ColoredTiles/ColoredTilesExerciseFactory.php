<?php
namespace Brainteaser\Domain\Exercise\ColoredTiles;

use Brainteaser\Domain\Exercise\SequenceNumber;
use Brainteaser\Domain\Training\Training;
use DateTime;

class ColoredTilesExerciseFactory
{
    /**
     * @var DifficultyFactory
     */
    private $difficultyFactory;

    /**
     * @var GridSizeFactory
     */
    private $gridSizeFactory;

    /**
     * @var ColoredTilesFactory
     */
    private $coloredTilesFactory;

    /**
     * @param DifficultyFactory $difficultyFactory
     * @param GridSizeFactory $gridSizeFactory
     * @param ColoredTilesFactory $coloredTilesFactory
     */
    public function __construct(
        DifficultyFactory $difficultyFactory,
        GridSizeFactory $gridSizeFactory,
        ColoredTilesFactory $coloredTilesFactory
    ) {
        $this->difficultyFactory = $difficultyFactory;
        $this->gridSizeFactory = $gridSizeFactory;
        $this->coloredTilesFactory = $coloredTilesFactory;
    }

    /**
     * @param Training $training
     * @param ColoredTilesExercise|null $lastExercise
     * @param ColoredTilesExercise|null $secondToLastExercise
     * @return ColoredTilesExercise
     */
    public function build(
        Training $training,
        ColoredTilesExercise $lastExercise = null,
        ColoredTilesExercise $secondToLastExercise = null
    ) : ColoredTilesExercise {
        $difficulty = $this->difficultyFactory->build(
            $lastExercise,
            $secondToLastExercise
        );
        $gridSize = $this->gridSizeFactory->build($difficulty);

        $sequenceNumber = new SequenceNumber(1);
        if (!is_null($lastExercise)) {
            $sequenceNumber = $lastExercise->getSequenceNumber()->increase();
        }

        return new ColoredTilesExercise(
            '',
            $sequenceNumber,
            $training,
            $difficulty,
            $gridSize,
            $this->coloredTilesFactory->build($difficulty, $gridSize),
            new DateTime()
        );
    }
}