<?php

namespace Tests\AppBundle\Controller;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class MoviesControllerTest extends BaseController
{
    public function testGetMovies()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/v1/movies');
        $response = $client->getResponse();

        $expectedData = [
            'total' => '30',
            'count' => 3,
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Harry Potter et la chambre des secrets'
                ],
                [
                    'id' => 2,
                    'name' => 'Fast and Furious 8'
                ],
                [
                    'id' => 3,
                    'name' => 'Taken 3'
                ],
            ]
        ];

        $this->assertJsonResponse($response, Response::HTTP_OK);
        $this->assertJsonContent($response, $expectedData);
    }

    public function testGetMoviesWithBadInput()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/v1/movies?order=bad');
        $response1 = $client->getResponse();

        $expectedData1 = [
            'error' => 'Bad query',
            'message' => 'Only allowed value for order is \'name\'',
        ];

        $this->assertJsonResponse($response1, Response::HTTP_BAD_REQUEST);
        $this->assertJsonContent($response1, $expectedData1);

        $crawler = $client->request('GET', '/v1/movies?order=name&dir=a');
        $response2 = $client->getResponse();

        $expectedData2 = [
            'error' => 'Bad query',
            'message' => 'Dir must be one of those: asc, desc',
        ];

        $this->assertJsonResponse($response2, Response::HTTP_BAD_REQUEST);
        $this->assertJsonContent($response2, $expectedData2);
    }

    public function testGetMoviesWithOrderAndDirection()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/v1/movies?order=name&dir=desc');
        $response = $client->getResponse();

        $expectedData = [
            'total' => '30',
            'count' => 3,
            'data' => [
                [
                    'id' => 3,
                    'name' => 'Taken 3'
                ],
                [
                    'id' => 1,
                    'name' => 'Harry Potter et la chambre des secrets'
                ],
                [
                    'id' => 2,
                    'name' => 'Fast and Furious 8'
                ],
            ]
        ];

        $this->assertJsonResponse($response, Response::HTTP_OK);
        $this->assertJsonContent($response, $expectedData);
    }
}
