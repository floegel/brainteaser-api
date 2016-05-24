<?php
namespace Brainteaser\Application\Command;


class StartExerciseCommand
{
    /**
     * @var string
     */
    private $trainingId;

    /**
     * @param string $trainingId
     */
    public function __construct(string $trainingId)
    {
        $this->trainingId = $trainingId;
    }

    /**
     * @return string
     */
    public function getTrainingId()
    {
        return $this->trainingId;
    }
}