<?php
namespace Brainteaser\InfrastructureBundle\Controller\Exercise;

use Brainteaser\Application\DataTransformer\ColoredTilesExerciseDataTransformer;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseRepository;
use Brainteaser\Domain\Exercise\ExerciseDoesNotExistException;
use Brainteaser\InfrastructureBundle\Response\ResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetExerciseController
{
    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ColoredTilesExerciseRepository
     */
    private $exerciseRepository;

    /**
     * @var ColoredTilesExerciseDataTransformer
     */
    private $exerciseDataTransformer;

    /**
     * @param ResponseFactory $responseFactory
     * @param ColoredTilesExerciseRepository $exerciseRepository
     * @param ColoredTilesExerciseDataTransformer $exerciseDataTransformer
     */
    public function __construct(
        ResponseFactory $responseFactory,
        ColoredTilesExerciseRepository $exerciseRepository,
        ColoredTilesExerciseDataTransformer $exerciseDataTransformer
    ) {
        $this->exerciseRepository = $exerciseRepository;
        $this->exerciseDataTransformer = $exerciseDataTransformer;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request) : Response
    {
        try {
            $TrainingId = $request->get('training_id');
            $exerciseId = $request->get('exercise_id');

            $exercise = $this->exerciseRepository->get($exerciseId, $TrainingId);

            return $this->responseFactory->createItemResponse(
                $exercise,
                $this->exerciseDataTransformer
            );
        } catch (ExerciseDoesNotExistException $e) {
            return $this->responseFactory->createNotFoundResponse();
        }
    }
}