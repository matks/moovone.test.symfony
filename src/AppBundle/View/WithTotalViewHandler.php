<?php

namespace AppBundle\View;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WithTotalViewHandler
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param ViewHandler $viewHandler
     * @param View $view
     * @param Request $request
     * @param string $format
     *
     * @return JsonResponse
     */
    public function createResponse(ViewHandler $handler, View $view, Request $request, $format)
    {
        $this->validateView($view);

        $viewData = $view->getData();

        $data = [
            'total' => $viewData['total'],
            'count' => count($viewData['data']),
            'data' => $viewData['data'],
        ];

        $json = $this->serializer->serialize($data, 'json');

        return new JsonResponse($json, 200, $view->getHeaders(), true);
    }

    /**
     * @param View $view
     *
     * @throws \RuntimeException
     */
    private function validateView(View $view)
    {
        $viewData = $view->getData();

        if (false === array_key_exists('data', $viewData)) {
            throw new \RuntimeException("Could not find mandatory 'data' node in view data");
        }
        if (false === array_key_exists('total', $viewData)) {
            throw new \RuntimeException("Could not find mandatory 'total' node in view data");
        }
    }
}
