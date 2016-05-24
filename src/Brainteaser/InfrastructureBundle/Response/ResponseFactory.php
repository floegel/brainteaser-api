<?php
namespace Brainteaser\InfrastructureBundle\Response;

use Brainteaser\Application\DataTransformer\DataTransformer;
use Symfony\Component\HttpFoundation\Response;

interface ResponseFactory
{
    /**
     * @param mixed $item
     * @param DataTransformer $dataTransformer
     * @return Response
     */
    public function createItemResponse($item, DataTransformer $dataTransformer) : Response;

    /**
     * @param array $collection
     * @param DataTransformer $dataTransformer
     * @return Response
     */
    public function createCollectionResponse(array $collection, DataTransformer $dataTransformer) : Response;

    /**
     * @param string $code
     * @param string $message
     * @return Response
     */
    public function createErrorResponse(string $code, string $message) : Response;

    /**
     * @return Response
     */
    public function createNotFoundResponse() : Response;

    /**
     * @param string $routeName
     * @param array $routeParameters
     * @return Response
     */
    public function createCreatedResponse(string $routeName, array $routeParameters) : Response;
}