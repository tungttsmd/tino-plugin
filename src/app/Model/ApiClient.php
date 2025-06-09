<?php

namespace Model;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class ApiClient
{
    private $sslVerify;
    private $baseUri;
    private $accessToken;
    private $configs;
    private $client;

    // Constructor
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->baseUri = "https://my.tino.vn/api/";
        $this->sslVerify = false;
        $this->configs = [
            "verify" => $this->sslVerify,
            "base_uri" => $this->baseUri,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        ];
        $this->client = new GuzzleClient($this->configs);
    }

    // Utilities
    protected function call(string $endpoint, $method = "get", array $addonOptions = [])
    {
        try {
            $response = $this->client->request(strtoupper($method), $endpoint, array_merge($this->configs, $addonOptions));
            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {
            throw new \RuntimeException('API request failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    // Get
    protected function baseUri()
    {
        return $this->baseUri;
    }
    protected function sslVerify()
    {
        return $this->sslVerify;
    }

    // Set
    protected function setBaseUri(string $uri)
    {
        $this->baseUri = $uri;
        return $this;
    }
    protected function setSslVerify(bool $sslVerify)
    {
        $this->sslVerify = $sslVerify;
        return $this;
    }
}
