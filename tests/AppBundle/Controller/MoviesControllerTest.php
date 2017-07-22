<?php

namespace Tests\AppBundle\Controller;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use JMS\Serializer\SerializerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MoviesControllerTest extends WebTestCase
{
    private $container;

    public function testIndex()
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

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();

        parent::setup();
        $fixtures = array(
            'AppBundle\DataFixtures\ORM\LoadMovieData',
        );

        $this->loadFixtures($fixtures, null, 'doctrine', ORMPurger::PURGE_MODE_TRUNCATE);
    }

    /**
     * @param Response $response
     * @param string $status
     */
    protected function assertJsonResponse(Response $response, $status)
    {
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($status, $response->getStatusCode());

        $content = $response->getContent();
        $this->assertIsValidJson($content);
    }

    /**
     * @param Response $response
     *
     * @param array $expectedData
     */
    protected function assertJsonContent(Response $response, array $expectedData)
    {
        $realData = $response->getContent();

        $this->assertEquals($this->serialize($expectedData), $realData);
    }

    /**
     * @param string $json
     *
     * @return bool
     */
    protected function assertIsValidJson($json)
    {
        $data = json_decode($json);

        return (null !== $data);
    }

    /**
     * @param array $data
     *
     * @return string
     */
    protected function serialize(array $data)
    {
        /** @var SerializerInterface $serializer */
        $serializer = $this->container->get('jms_serializer');
        $json = $serializer->serialize($data, 'json');

        return $json;
    }
}
