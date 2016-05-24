<?php
namespace Brainteaser\InfrastructureBundle\Controller\Training;

use Brainteaser\Application\DataTransformer\TrainingDataTransformer;
use Brainteaser\Domain\Training\TrainingRepository;
use Brainteaser\InfrastructureBundle\Response\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class GetHighscoresController
{
    /**
     * @var TrainingRepository
     */
    private $trainingRepository;

    /**
     * @var TrainingDataTransformer
     */
    private $trainingDataTransformer;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @param ResponseFactory $responseFactory
     * @param TrainingRepository $trainingRepository
     * @param TrainingDataTransformer $trainingDataTransformer
     */
    public function __construct(
        ResponseFactory $responseFactory,
        TrainingRepository $trainingRepository,
        TrainingDataTransformer $trainingDataTransformer
    ) {
        $this->trainingRepository = $trainingRepository;
        $this->trainingDataTransformer = $trainingDataTransformer;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @return Response
     */
    public function handleRequest(): Response
    {
        $trainingCollection = $this->trainingRepository->findHighscores();

        return $this->responseFactory->createCollectionResponse(
            $trainingCollection,
            $this->trainingDataTransformer
        );
    }
}