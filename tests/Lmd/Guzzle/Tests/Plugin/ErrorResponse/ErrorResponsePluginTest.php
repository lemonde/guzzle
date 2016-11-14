<?php

namespace Lmd\Guzzle\Tests\Plugin\ErrorResponse;

use Lmd\Guzzle\Service\Client;
use Lmd\Guzzle\Http\Message\Response;
use Lmd\Guzzle\Plugin\ErrorResponse\ErrorResponsePlugin;
use Lmd\Guzzle\Service\Description\ServiceDescription;
use Lmd\Guzzle\Tests\Mock\ErrorResponseMock;

/**
 * @covers \Lmd\Guzzle\Plugin\ErrorResponse\ErrorResponsePlugin
 */
class ErrorResponsePluginTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    protected $client;

    public static function tearDownAfterClass()
    {
        self::getServer()->flush();
    }

    public function setUp()
    {
        $mockError = 'Lmd\Guzzle\Tests\Mock\ErrorResponseMock';
        $description = ServiceDescription::factory(array(
            'operations' => array(
                'works' => array(
                    'httpMethod' => 'GET',
                    'errorResponses' => array(
                        array('code' => 500, 'class' => $mockError),
                        array('code' => 503, 'reason' => 'foo', 'class' => $mockError),
                        array('code' => 200, 'reason' => 'Error!', 'class' => $mockError)
                    )
                ),
                'bad_class' => array(
                    'httpMethod' => 'GET',
                    'errorResponses' => array(
                        array('code' => 500, 'class' => 'Does\\Not\\Exist')
                    )
                ),
                'does_not_implement' => array(
                    'httpMethod' => 'GET',
                    'errorResponses' => array(
                        array('code' => 500, 'class' => __CLASS__)
                    )
                ),
                'no_errors' => array('httpMethod' => 'GET'),
                'no_class' => array(
                    'httpMethod' => 'GET',
                    'errorResponses' => array(
                        array('code' => 500)
                    )
                ),
            )
        ));
        $this->client = new Client($this->getServer()->getUrl());
        $this->client->setDescription($description);
    }

    /**
     * @expectedException \Lmd\Guzzle\Http\Exception\ServerErrorResponseException
     */
    public function testSkipsWhenErrorResponsesIsNotSet()
    {
        $this->getServer()->enqueue("HTTP/1.1 500 Foo\r\nContent-Length: 0\r\n\r\n");
        $this->client->addSubscriber(new ErrorResponsePlugin());
        $this->client->getCommand('no_errors')->execute();
    }

    public function testSkipsWhenErrorResponsesIsNotSetAndAllowsSuccess()
    {
        $this->getServer()->enqueue("HTTP/1.1 200 OK\r\nContent-Length: 0\r\n\r\n");
        $this->client->addSubscriber(new ErrorResponsePlugin());
        $this->client->getCommand('no_errors')->execute();
    }

    /**
     * @expectedException \Lmd\Guzzle\Plugin\ErrorResponse\Exception\ErrorResponseException
     * @expectedExceptionMessage Does\Not\Exist does not exist
     */
    public function testEnsuresErrorResponseExists()
    {
        $this->getServer()->enqueue("HTTP/1.1 500 Foo\r\nContent-Length: 0\r\n\r\n");
        $this->client->addSubscriber(new ErrorResponsePlugin());
        $this->client->getCommand('bad_class')->execute();
    }

    /**
     * @expectedException \Lmd\Guzzle\Plugin\ErrorResponse\Exception\ErrorResponseException
     * @expectedExceptionMessage must implement Lmd\Guzzle\Plugin\ErrorResponse\ErrorResponseExceptionInterface
     */
    public function testEnsuresErrorResponseImplementsInterface()
    {
        $this->getServer()->enqueue("HTTP/1.1 500 Foo\r\nContent-Length: 0\r\n\r\n");
        $this->client->addSubscriber(new ErrorResponsePlugin());
        $this->client->getCommand('does_not_implement')->execute();
    }

    public function testThrowsSpecificErrorResponseOnMatch()
    {
        try {
            $this->getServer()->enqueue("HTTP/1.1 500 Foo\r\nContent-Length: 0\r\n\r\n");
            $this->client->addSubscriber(new ErrorResponsePlugin());
            $command = $this->client->getCommand('works');
            $command->execute();
            $this->fail('Exception not thrown');
        } catch (ErrorResponseMock $e) {
            $this->assertSame($command, $e->command);
            $this->assertEquals(500, $e->response->getStatusCode());
        }
    }

    /**
     * @expectedException \Lmd\Guzzle\Tests\Mock\ErrorResponseMock
     */
    public function testThrowsWhenCodeAndPhraseMatch()
    {
        $this->getServer()->enqueue("HTTP/1.1 200 Error!\r\nContent-Length: 0\r\n\r\n");
        $this->client->addSubscriber(new ErrorResponsePlugin());
        $this->client->getCommand('works')->execute();
    }

    public function testSkipsWhenReasonDoesNotMatch()
    {
        $this->getServer()->enqueue("HTTP/1.1 200 OK\r\nContent-Length: 0\r\n\r\n");
        $this->client->addSubscriber(new ErrorResponsePlugin());
        $this->client->getCommand('works')->execute();
    }

    public function testSkipsWhenNoClassIsSet()
    {
        $this->getServer()->enqueue("HTTP/1.1 200 OK\r\nContent-Length: 0\r\n\r\n");
        $this->client->addSubscriber(new ErrorResponsePlugin());
        $this->client->getCommand('no_class')->execute();
    }
}
