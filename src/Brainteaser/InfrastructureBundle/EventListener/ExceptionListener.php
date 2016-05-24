<?php
namespace Brainteaser\InfrastructureBundle\EventListener;

use Brainteaser\InfrastructureBundle\Response\ResponseFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @param LoggerInterface $logger
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        LoggerInterface $logger,
        ResponseFactory $responseFactory
    ) {
        $this->logger = $logger;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Catch all unhandled exceptions
     * Log the exception, but do not expose it to the world
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $this->logger->error($exception);

        $event->setResponse(
            $this->responseFactory->createErrorResponse('ERROR', 'An error occured')
        );
    }
}