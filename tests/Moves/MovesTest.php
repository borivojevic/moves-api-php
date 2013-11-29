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

    public function testDailyActivities()
    {
        $this->plugin->addResponse(__DIR__ . "/Fakes/daily_activities.json");

        $dailyActivities = $this->Moves->dailyActivities();

        $this->assertTrue(is_array($dailyActivities), "Expected daily activities to be an array");
        $this->assertEquals(6, count($dailyActivities), "Expected to return correct number of results");
    }

    public function testDailyPlaces()
    {
        $this->plugin->addResponse(__DIR__ . "/Fakes/daily_places.json");

        $dailyPlaces = $this->Moves->dailyPlaces();

        $this->assertTrue(is_array($dailyPlaces), "Expected daily places to be an array");
        $this->assertEquals(6, count($dailyPlaces), "Expected to return correct number of results");
    }

    public function testDailyStoryline()
    {
        $this->plugin->addResponse(__DIR__ . "/Fakes/daily_storyline.json");

        $dailyStoryline = $this->Moves->dailyStoryline();

        $this->assertTrue(is_array($dailyStoryline), "Expected daily storyline to be an array");
        $this->assertEquals(7, count($dailyStoryline[0]['segments']), "Expected to return correct number of results");
    }

    public function getRangeProvider()
    {
        return array(
            // Current day
            array(
                null,
                "/" . date("Y-m-d"),
                array()
            ),
            // Single day
            array(
                array(new \DateTime('2013-11-20')),
                "/2013-11-20",
                array()
            ),
            array(
                array('2013-11-20'),
                "/2013-11-20",
                array()
            ),
            // Week
            array(
                array('2013-W48'),
                "/2013-W48",
                array()
            ),
            // Month
            array(
                array('2013-11'),
                "/2013-11",
                array()
            ),
            // Date range
            array(
                array(array('from' => new \DateTime('2013-11-10'), 'to' => new \DateTime('2013-11-20'))),
                "",
                array('from' => '2013-11-10', 'to' => '2013-11-20')
            ),
            array(
                array(array('from' => '2013-11-10', 'to' => '2013-11-20')),
                "",
                array('from' => '2013-11-10', 'to' => '2013-11-20')
            ),
            array(
                array(new \DateTime('2013-11-10'), new \DateTime('2013-11-20')),
                "",
                array('from' => '2013-11-10', 'to' => '2013-11-20')
            ),
            array(
                array('2013-11-10', '2013-11-20'),
                "",
                array('from' => '2013-11-10', 'to' => '2013-11-20')
            ),
            // Past days
            array(
                array(array('pastDays' => 3)),
                "",
                array('pastDays' => '3')
            ),
            // Get daily storyline with track points
            array(
                array(array('trackPoints' => 'true')),
                "/" . date("Y-m-d"),
                array('trackPoints' => 'true')
            ),
            array(
                array('2013-11-10', array('trackPoints' => 'true')),
                "/2013-11-10",
                array('trackPoints' => 'true')
            )
        );
    }

    /**
     * Test for get range method
     *
     * @dataProvider getRangeProvider
     */
    public function testGetRange($args, $expectedPath, $expectedParams)
    {
        $partialMock = $this->getMock('\Moves\Moves', array('get'), array('secret'));
        $partialMock->expects($this->once())
            ->method('get')
            ->with($expectedPath, $expectedParams);
        $partialMock->getRange("", $args);
    }
}
