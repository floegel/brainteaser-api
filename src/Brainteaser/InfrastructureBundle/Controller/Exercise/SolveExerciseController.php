<?php
namespace Brainteaser\InfrastructureBundle\Controller\Exercise;

use Brainteaser\Application\Command\SolveExerciseCommand;
use Brainteaser\Application\DataTransformer\SolveColoredTilesExerciseResultDataTransformer;
use Brainteaser\Domain\Exercise\ColoredTiles\ColoredTilesExerciseSolutionHasInvalidNumberOfTilesException;
use Brainteaser\Domain\Exercise\ExerciseAlreadySolvedException;
use Brainteaser\Domain\Exercise\ExerciseDoesNotExistException;
use Brainteaser\Domain\Exercise\Tile;
use Brainteaser\Domain\Exercise\TileSet;
use Brainteaser\InfrastructureBundle\Exception\InputValidationException;
use Brainteaser\InfrastructureBundle\Response\ResponseFactory;
use Exception;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SolveExerciseController
{
    /**
     * @var SolveColoredTilesExerciseResultDataTransformer
     */
    private $solveExerciseResultDataTransformer;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @param ResponseFactory $responseFactory
     * @param CommandBus $commandBus
     * @param SolveColoredTilesExerciseResultDataTransformer $solveExerciseResultDataTransformer
     */
    public function __construct(
        ResponseFactory $responseFactory,
        CommandBus $commandBus,
        SolveColoredTilesExerciseResultDataTransformer $solveExerciseResultDataTransformer
    ) {
        $this->commandBus = $commandBus;
        $this->solveExerciseResultDataTransformer = $solveExerciseResultDataTransformer;
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
            $exerciseId = $request->get('exercise_id');

            // TODO move request parsing / validation to another class?
            $requestBody = json_decode($request->getContent(), true);

            if (!is_array($requestBody)) {
                throw new InputValidationException(
                    'MALFORMED-JSON',
                    'Malformed JSON'
                );
            }

            if (!array_key_exists('tiles', $requestBody)) {
                throw new InputValidationException(
                    'MISSING-PARAMETER',
                    'Missing parameter: tiles'
                );
            }

            $tiles = array_map(function($tileData) {
                if (!array_key_exists('x', $tileData) || !array_key_exists('y', $tileData)) {
                    throw new InputValidationException(
                        'INVALID-VALUE',
                        'Invalid structure for tiles'
                    );
                }
                try {
                    $tile = new Tile($tileData['x'], $tileData['y']);
                } catch (Exception $e) {
                    throw new InputValidationException(
                        'INVALID-VALUE',
                        'Invalid value for tiles'
                    );
                }
                return $tile;
            }, $requestBody['tiles']);

            try {
                $solveExerciseResult = $this->commandBus->handle(
                    new SolveExerciseCommand(
                        $trainingId,
                        $exerciseId,
                        new TileSet($tiles)
                    )
                );
            } catch (ColoredTilesExerciseSolutionHasInvalidNumberOfTilesException $e) {
                throw new InputValidationException(
                    'INVALID-VALUE',
                    'Invalid number of tiles'
                );
            }

            return $this->responseFactory->createItemResponse(
                $solveExerciseResult,
                $this->solveExerciseResultDataTransformer
            );
        } catch (ExerciseDoesNotExistException $e) {
            return $this->responseFactory->createNotFoundResponse();
        } catch (InputValidationException $e) {
            return $this->responseFactory->createErrorResponse(
                $e->getErrorCode(),
                $e->getErrorMessage()
            );
        } catch (ExerciseAlreadySolvedException $e) {
            return $this->responseFactory->createErrorResponse(
                'EXERCISE-ALREADY-SOLVED',
                'Exercise has already been solved'
            );
        }
    }
}