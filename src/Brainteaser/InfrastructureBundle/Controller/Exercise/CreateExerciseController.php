<?php
namespace Brainteaser\InfrastructureBundle\Controller\Exercise;

use Brainteaser\Application\Command\StartExerciseCommand;
use Brainteaser\Domain\Exercise\Exercise;
use Brainteaser\Domain\Exercise\PreviousUnsolvedExerciseException;
use Brainteaser\Domain\Training\TrainingAlreadyFinishedException;
use Brainteaser\Domain\Training\TrainingDoesNotExistException;
use Brainteaser\InfrastructureBundle\Response\ResponseFactory;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateExerciseController
{
    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param ResponseFactory $responseFactory
     * @param CommandBus $commandBus
     */
    public function __construct(
        ResponseFactory $responseFactory,
        CommandBus $commandBus
    ) {
        $this->responseFactory = $responseFactory;
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request) : Response
    {
        try {
            /** @var Exercise $exercise */
            $exercise = $this->commandBus->handle(
                new StartExerciseCommand(
                    $request->get('training_id')
                )
            );
            return $this->responseFactory->createCreatedResponse(
                'get_exercise',
                [
                    'training_id' => $exercise->getTraining()->getId(),
                    'exercise_id' => $exercise->getId()
                ]
            );
        } catch (TrainingDoesNotExistException $e) {
            return $this->responseFactory->createNotFoundResponse();
        } catch (PreviousUnsolvedExerciseException $e) {
            return $this->responseFactory->createErrorResponse(
                'TRAINING-UNSOLVED-EXERCISES',
                'There are unsolved exercises for the training that ' .
                'need to be solved before creating a new exercise'
            );
        } catch (TrainingAlreadyFinishedException $e) {
            return $this->responseFactory->createErrorResponse(
                'TRAINING-ALREADY-FINISHED',
                'The training has already been finished'
            );
        }
    }
}