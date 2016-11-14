<?php

namespace Lmd\Guzzle\Tests\Common;

use Lmd\Guzzle\Common\Event;
use Lmd\Guzzle\Common\AbstractHasDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @covers \Lmd\Guzzle\Common\AbstractHasDispatcher
 */
class AbstractHasAdapterTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    public function testDoesNotRequireRegisteredEvents()
    {
        $this->assertEquals(array(), AbstractHasDispatcher::getAllEvents());
    }

    public function testAllowsDispatcherToBeInjected()
    {
        $d = new EventDispatcher();
        $mock = $this->getMockForAbstractClass('Lmd\Guzzle\Common\AbstractHasDispatcher');
        $this->assertSame($mock, $mock->setEventDispatcher($d));
        $this->assertSame($d, $mock->getEventDispatcher());
    }

    public function testCreatesDefaultEventDispatcherIfNeeded()
    {
        $mock = $this->getMockForAbstractClass('Lmd\Guzzle\Common\AbstractHasDispatcher');
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventDispatcher', $mock->getEventDispatcher());
    }

    public function testHelperDispatchesEvents()
    {
        $data = array();
        $mock = $this->getMockForAbstractClass('Lmd\Guzzle\Common\AbstractHasDispatcher');
        $mock->getEventDispatcher()->addListener('test', function(Event $e) use (&$data) {
            $data = $e->getIterator()->getArrayCopy();
        });
        $mock->dispatch('test', array(
            'param' => 'abc'
        ));
        $this->assertEquals(array(
            'param' => 'abc',
        ), $data);
    }

    public function testHelperAttachesSubscribers()
    {
        $mock = $this->getMockForAbstractClass('Lmd\Guzzle\Common\AbstractHasDispatcher');
        $subscriber = $this->getMockForAbstractClass('Symfony\Component\EventDispatcher\EventSubscriberInterface');

        $dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->setMethods(array('addSubscriber'))
            ->getMock();

        $dispatcher->expects($this->once())
            ->method('addSubscriber');

        $mock->setEventDispatcher($dispatcher);
        $mock->addSubscriber($subscriber);
    }
}
