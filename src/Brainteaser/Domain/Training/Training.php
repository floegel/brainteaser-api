<?php
namespace Brainteaser\Domain\Training;

use DateTime;

class Training
{
    const NUM_EXERCISES = 12;

    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTime
     */
    private $startedAt;

    /**
     * @var DateTime|null
     */
    private $finishedAt;

    /**
     * @var int
     */
    private $score;

    /**
     * @param string $id
     * @param DateTime $startedAt
     * @param DateTime|null $finishedAt
     * @param int $score
     */
    public function __construct(
        string $id,
        DateTime $startedAt,
        DateTime $finishedAt = null,
        int $score = 0
    ) {
        $this->id = $id;
        $this->startedAt = $startedAt;
        $this->finishedAt = $finishedAt;
        $this->score = $score;
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getScore() : int
    {
        return $this->score;
    }

    /**
     * @return int
     */
    public function getNumExercises() : int
    {
        return self::NUM_EXERCISES;
    }

    /**
     * @param int $amount
     */
    public function increaseScore(int $amount)
    {
        $this->score += $amount;
    }

    public function markAsFinished()
    {
        $this->finishedAt = new DateTime;
    }

    /**
     * @return bool
     */
    public function isFinished() : bool
    {
        return !is_null($this->finishedAt);
    }
}