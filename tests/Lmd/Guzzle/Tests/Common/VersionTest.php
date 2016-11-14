<?php

namespace Lmd\Guzzle\Tests\Common;

use Lmd\Guzzle\Common\Version;

/**
 * @covers \Lmd\Guzzle\Common\Version
 */
class VersionTest extends \Lmd\Guzzle\Tests\GuzzleTestCase
{
    /**
     * @expectedException \PHPUnit_Framework_Error_Deprecated
     */
    public function testEmitsWarnings()
    {
        Version::$emitWarnings = true;
        Version::warn('testing!');
    }

    public function testCanSilenceWarnings()
    {
        Version::$emitWarnings = false;
        Version::warn('testing!');
        Version::$emitWarnings = true;
    }
}
