<?php

namespace Tests\AppBundle\Controller;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class ExceptionControllerTest extends BaseController
{
    public function testBadUrl()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/v1/a');
        $response1 = $client->getResponse();

        $this->assertJsonResponse($response1, Response::HTTP_NOT_FOUND);
    }
}
