<?php

namespace Repository;

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
            'headers' => ['Authorization' => 'Bearer ' . $this->accessToken]
        ];
        $this->client = new GuzzleClient($this->configs);
    }

    // Utilities
    /**
     * @param string $endpoint
     * @param mixed $method
     * @param array $addonOptions
     * @throws \RuntimeException
     * @return \Psr\Http\Message\ResponseInterface
     * raw() là một method dùng để lấy trực tiếp phản hồi api không qua xử lí, nhằm để phát triển api 
     */
    protected function raw(string $endpoint, $method = "get", array $addonOptions = [])
    {
        try {
            $response = $this->client->request(strtoupper($method), $endpoint, array_merge($this->configs, $addonOptions));
            return $response;
        } catch (GuzzleException $e) {
            throw new \RuntimeException('API request failed: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }
    /**
     * Summary of call
     * @param string $endpoint
     * @param mixed $method
     * @param array $addonOptions
     * @throws \RuntimeException
     * call() là một chức năng phát triển dựa trên raw chỉ trả về dữ liệu được làm sạch
     */
    protected function call(string $endpoint, $method = "get", array $addonOptions = [])
    {
        try {
            $response = $this->raw($endpoint, $method, $addonOptions);
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
