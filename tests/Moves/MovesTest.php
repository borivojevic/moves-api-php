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

    public function dailySummaryProvider()
    {
        return array(
            array(
                'daily_summary.json',
                new \DateTime('yesterday'),
                1
            ),
            array(
                'daily_summary_range.json',
                array('from' => new \DateTime('yesterday'), 'to' => new \DateTime('today')),
                2
            )
        );
    }

    /**
     * Test for get daily summary method
     *
     * @dataProvider dailySummaryProvider
     */
    public function testDailySummary($input, $params, $expected)
    {
        $this->plugin->addResponse(__DIR__ . "/Fakes/$input");

        $dailySummary = $this->Moves->dailySummary($params);

        $this->assertTrue(is_array($dailySummary), "Expected daily summary to be an array");
        $this->assertEquals($expected, count($dailySummary), "Expected to return correct number of results");
    }
}
