<?php

namespace Moves;

use Guzzle\Http\Client as GuzzleClient;

class Moves
{
    private $endpoint = "https://api.moves-app.com/api/v1/";

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
        $format = "Y-m-d";

        if (is_array($args[0])) {
            list($extra_path, $params) = ["", $args[0]];
        } elseif (count($args) > 1) {
            list($extra_path, $params) = ["", array('from' => $args[0], 'to' => $args[1])];
        } elseif ($args[0] instanceof \DateTime) {
            list($extra_path, $params) = ["/".$args[0]->format($format), @$args[1]];
        } elseif ($args[0]) {
            list($extra_path, $params) = ["/{$args['0']}", false];
        } else {
            list($extra_path, $params) = ["", false];
        }
        $params = $params ?: [];

        // default to current day
        if (!$extra_path && !isset($params["to"]) && !isset($params["from"]) && !isset($params["pastDays"])) {
            $extra_path = "/" . date($format);
        }

        if (isset($params["to"]) && $params["to"] instanceof \DateTime) {
            $params["to"] = $params["to"]->format($format);
        }

        if (isset($params["from"]) && $params["from"] instanceof \DateTime) {
            $params["from"] = $params["from"]->format($format);
        }

        return $this->get("{$path}{$extra_path}", $params);
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
