<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Salsan\Announcements;

final class allTest extends TestCase
{
    public function testInit(): object
    {
        $feed = new Announcements\All(120);
        $this->assertIsObject($feed);

        return $feed;
    }

    /**
     * @depends testInit
     */

    public function testGetdata($feed)
    {
        $this->assertIsArray($feed->getData());
    }

    /**
     * @depends testInit
     */

    public function testLengthArray($feed)
    {
        $this->assertEquals(120, count($feed->getData()));
    }
}
