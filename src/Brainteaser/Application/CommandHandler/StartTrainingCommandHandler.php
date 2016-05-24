<?php
namespace Brainteaser\Application\CommandHandler;

use Brainteaser\Domain\Training\Training;
use Brainteaser\Domain\Training\TrainingFactory;
use Brainteaser\Domain\Training\TrainingRepository;

class StartTrainingCommandHandler
{
    /**
     * @var TrainingFactory
     */
    private $trainingFactory;

    /**
     * @var TrainingRepository
     */
    private $trainingsRepository;

    /**
     * @param TrainingFactory $trainingFactory
     * @param TrainingRepository $trainingsRepository
     */
    public function __construct(
        TrainingFactory $trainingFactory,
        TrainingRepository $trainingsRepository
    ) {
        $this->trainingFactory = $trainingFactory;
        $this->trainingsRepository = $trainingsRepository;
    }

    /**
     * @return Training
     */
    public function handle()
    {
        $training = $this->trainingFactory->build();
        $this->trainingsRepository->add($training);
        return $training;
    }
}
