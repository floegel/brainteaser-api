<?php
namespace Brainteaser\Domain\Training;

interface TrainingRepository
{
    /**
     * @param string $id
     * @return Training
     * @throws TrainingDoesNotExistException
     */
    public function get(string $id) : Training;

    /**
     * @return Training[]
     */
    public function findHighscores() : array;

    /**
     * @param Training $training
     */
    public function add(Training $training);
}