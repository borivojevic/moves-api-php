<?php

namespace Moves;

use Guzzle\Http\Client as GuzzleClient;

class Moves
{
    private $endpoint = "https://api.moves-app.com/api/1.1/";

    private $accessToken;

    public $guzzleClient;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function profile()
    {
        return $this->get('user/profile');
    }

    public function dailySummary()
    {
        $args = func_get_args();
        return $this->getRange("user/summary/daily", $args);
    }

    public function dailyActivities()
    {
        $args = func_get_args();
        return $this->getRange("user/activities/daily", $args);
    }

    public function dailyPlaces()
    {
        $args = func_get_args();
        return $this->getRange("user/places/daily", $args);
    }

    public function dailyStoryline()
    {
        $args = func_get_args();
        return $this->getRange("user/storyline/daily", $args);
    }

    public function get($path, $params = array())
    {
        $client = $this->guzzleClient ?: new GuzzleClient($this->endpoint);

        $request = $client->get(
            $path,
            array('Accept' => 'application/json'),
            array('query' => $params)
        );
        $request->addHeader('Authorization', "Bearer {$this->accessToken}");
        $request->addHeader('Accept-Encoding', 'gzip');


        $response = $request->send();

        return $this->handleResponse($response);
    }

    public function getRange($path, $args)
    {
        $arg0 = isset($args[0]) ? $args[0] : false;
        $arg1 = isset($args[1]) ? $args[1] : false;

        $ProcessFunctionArguments = new \Moves\ProcessFunctionArguments();
        list($extraPath, $params) = $ProcessFunctionArguments->process($arg0, $arg1);
        $params = $params ?: array();

        return $this->get("{$path}{$extraPath}", $params);
    }

    private function handleResponse($response)
    {
        if (!$response || !$response->isSuccessful()) {
            throw new \Exception("HTTP request failed");
        }

        if ($response->getContentLength() == 0) {
            throw new \Exception("HTTP body empty");
        }

        try {
            $responseJsonArray = json_decode($response->getBody(), true);
        } catch (RuntimeException $e) {
            throw new \Exception("Invalid JSON response: " . $e->getMessage());
        }

        return $responseJsonArray;
    }
}
