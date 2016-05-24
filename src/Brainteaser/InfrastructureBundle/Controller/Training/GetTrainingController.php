<?php
namespace Brainteaser\InfrastructureBundle\Controller\Training;

use Brainteaser\Application\DataTransformer\TrainingDataTransformer;
use Brainteaser\Domain\Training\TrainingDoesNotExistException;
use Brainteaser\Domain\Training\TrainingRepository;
use Brainteaser\InfrastructureBundle\Response\ResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetTrainingController
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
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request) : Response
    {
        try {
            $trainingId = $request->get('training_id');
            $training = $this->trainingRepository->get($trainingId);

            return $this->responseFactory->createItemResponse(
                $training,
                $this->trainingDataTransformer
            );
        } catch (TrainingDoesNotExistException $e) {
            return $this->responseFactory->createNotFoundResponse();
        }
    }
}