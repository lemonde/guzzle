<?php

namespace Lmd\Guzzle\Service\Command\LocationVisitor;

use Lmd\Guzzle\Common\Exception\InvalidArgumentException;
use Lmd\Guzzle\Service\Command\LocationVisitor\Request\RequestVisitorInterface;
use Lmd\Guzzle\Service\Command\LocationVisitor\Response\ResponseVisitorInterface;

/**
 * Flyweight factory used to instantiate request and response visitors
 */
class VisitorFlyweight
{
    /** @var self Singleton instance of self */
    protected static $instance;

    /** @var array Default array of mappings of location names to classes */
    protected static $defaultMappings = array(
        'request.body'          => 'Lmd\Guzzle\Service\Command\LocationVisitor\Request\BodyVisitor',
        'request.header'        => 'Lmd\Guzzle\Service\Command\LocationVisitor\Request\HeaderVisitor',
        'request.json'          => 'Lmd\Guzzle\Service\Command\LocationVisitor\Request\JsonVisitor',
        'request.postField'     => 'Lmd\Guzzle\Service\Command\LocationVisitor\Request\PostFieldVisitor',
        'request.postFile'      => 'Lmd\Guzzle\Service\Command\LocationVisitor\Request\PostFileVisitor',
        'request.query'         => 'Lmd\Guzzle\Service\Command\LocationVisitor\Request\QueryVisitor',
        'request.response_body' => 'Lmd\Guzzle\Service\Command\LocationVisitor\Request\ResponseBodyVisitor',
        'request.responseBody'  => 'Lmd\Guzzle\Service\Command\LocationVisitor\Request\ResponseBodyVisitor',
        'request.xml'           => 'Lmd\Guzzle\Service\Command\LocationVisitor\Request\XmlVisitor',
        'response.body'         => 'Lmd\Guzzle\Service\Command\LocationVisitor\Response\BodyVisitor',
        'response.header'       => 'Lmd\Guzzle\Service\Command\LocationVisitor\Response\HeaderVisitor',
        'response.json'         => 'Lmd\Guzzle\Service\Command\LocationVisitor\Response\JsonVisitor',
        'response.reasonPhrase' => 'Lmd\Guzzle\Service\Command\LocationVisitor\Response\ReasonPhraseVisitor',
        'response.statusCode'   => 'Lmd\Guzzle\Service\Command\LocationVisitor\Response\StatusCodeVisitor',
        'response.xml'          => 'Lmd\Guzzle\Service\Command\LocationVisitor\Response\XmlVisitor'
    );

    /** @var array Array of mappings of location names to classes */
    protected $mappings;

    /** @var array Cache of instantiated visitors */
    protected $cache = array();

    /**
     * @return self
     * @codeCoverageIgnore
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param array $mappings Array mapping request.name and response.name to location visitor classes. Leave null to
     *                        use the default values.
     */
    public function __construct(array $mappings = null)
    {
        $this->mappings = $mappings === null ? self::$defaultMappings : $mappings;
    }

    /**
     * Get an instance of a request visitor by location name
     *
     * @param string $visitor Visitor name
     *
     * @return RequestVisitorInterface
     */
    public function getRequestVisitor($visitor)
    {
        return $this->getKey('request.' . $visitor);
    }

    /**
     * Get an instance of a response visitor by location name
     *
     * @param string $visitor Visitor name
     *
     * @return ResponseVisitorInterface
     */
    public function getResponseVisitor($visitor)
    {
        return $this->getKey('response.' . $visitor);
    }

    /**
     * Add a response visitor to the factory by name
     *
     * @param string                  $name    Name of the visitor
     * @param RequestVisitorInterface $visitor Visitor to add
     *
     * @return self
     */
    public function addRequestVisitor($name, RequestVisitorInterface $visitor)
    {
        $this->cache['request.' . $name] = $visitor;

        return $this;
    }

    /**
     * Add a response visitor to the factory by name
     *
     * @param string                   $name    Name of the visitor
     * @param ResponseVisitorInterface $visitor Visitor to add
     *
     * @return self
     */
    public function addResponseVisitor($name, ResponseVisitorInterface $visitor)
    {
        $this->cache['response.' . $name] = $visitor;

        return $this;
    }

    /**
     * Get a visitor by key value name
     *
     * @param string $key Key name to retrieve
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    private function getKey($key)
    {
        if (!isset($this->cache[$key])) {
            if (!isset($this->mappings[$key])) {
                list($type, $name) = explode('.', $key);
                throw new InvalidArgumentException("No {$type} visitor has been mapped for {$name}");
            }
            $this->cache[$key] = new $this->mappings[$key];
        }

        return $this->cache[$key];
    }
}
