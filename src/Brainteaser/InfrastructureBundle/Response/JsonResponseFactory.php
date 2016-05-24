<?php
namespace Brainteaser\InfrastructureBundle\Response;

use Brainteaser\Application\DataTransformer\DataTransformer;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseFactory implements ResponseFactory
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param mixed $item
     * @param DataTransformer $dataTransformer
     * @return Response
     */
    public function createItemResponse($item, DataTransformer $dataTransformer) : Response
    {
        return new JsonResponse(
            [
                'data' => $dataTransformer->transform($item)
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @param array $collection
     * @param DataTransformer $dataTransformer
     * @return Response
     */
    public function createCollectionResponse(
        array $collection,
        DataTransformer $dataTransformer
    ) : Response {
        $data = [];
        foreach ($collection as $item) {
            $data[] = $dataTransformer->transform($item);
        }
        return new JsonResponse(
            [
                'data' => $data
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @param string $code
     * @param string $message
     * @return Response
     */
    public function createErrorResponse(string $code, string $message) : Response
    {
        return new JsonResponse(
            [
                'error' => [
                    'code' => $code,
                    'http_code' => Response::HTTP_BAD_REQUEST,
                    'message' => $message
                ]
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @return Response
     */
    public function createNotFoundResponse() : Response
    {
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @param string $routeName
     * @param array $routeParameters
     * @return Response
     */
    public function createCreatedResponse(string $routeName, array $routeParameters) : Response
    {
        $location = $this->router->generate(
            $routeName,
            $routeParameters
        );
        return new JsonResponse(
            null,
            Response::HTTP_CREATED,
            [
                'Location' => $location
            ]
        );
    }
}