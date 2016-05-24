<?php
namespace Brainteaser\InfrastructureBundle\Controller\Training;

use Brainteaser\Application\Command\StartTrainingCommand;
use Brainteaser\InfrastructureBundle\Response\ResponseFactory;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Response;

class CreateTrainingController
{
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
     */
    public function __construct(
        ResponseFactory $responseFactory,
        CommandBus $commandBus
    ) {
        $this->commandBus = $commandBus;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @return Response
     */
    public function handleRequest() : Response
    {
        $training = $this->commandBus->handle(
            new StartTrainingCommand()
        );
        return $this->responseFactory->createCreatedResponse(
            'get_training',
            [
                'training_id' => $training->getId()
            ]
        );
    }
}