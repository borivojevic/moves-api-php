<?php
namespace Moves\Tests;

use Guzzle\Http\Client;
use Guzzle\Plugin\Mock\MockPlugin;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $client = new \Guzzle\Http\Client();
        $client->addSubscriber($this->plugin);
        $this->Moves = new \Moves\Moves('secret');
        $this->Moves->guzzleClient = $client;
    }

    public function tearDown()
    {
        unset($this->plugin);
        unset($this->Moves);
        parent::tearDown();
    }

    public function testProfile()
    {
        $this->plugin->addResponse(__DIR__ . '/Fakes/profile.json');

        $profile = $this->Moves->profile();

        $this->assertTrue(is_array($profile), "Expected profile to be an array");
        $this->assertEquals(5468213354570535, $profile['userId'], "Expected to return correct user id number");
    }
}
