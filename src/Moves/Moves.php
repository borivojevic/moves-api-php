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

    private function get($path, $params = array())
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
