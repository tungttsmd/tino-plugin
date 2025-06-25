<?php

namespace Repository;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class ApiClient
{
    private $sslVerify;
    private $baseUri;
    private $accessToken;
    private $configs;
    private $client;
    public static $staticBaseUri = 'https://api.tino.vn/';

    // Static
    public static function staticBaseUri()
    {
        return self::$staticBaseUri;
    }

    // Constructor
    public function __construct($accessToken)
    {
        if (empty($accessToken)) {
            throw new \InvalidArgumentException("Access token không tồn tại hoặc rỗng");
        } else {
            $this->accessToken = $accessToken;
        }
        $this->baseUri = self::$staticBaseUri;
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
    public function raw($endpoint, $method = 'get', $options = [])
    {
        try {
            $response = $this->client->request(strtoupper($method), $endpoint, $options);
            return $response;
        } catch (ClientException $e) {
            // Bắt lỗi 4xx như 401 Unauthorized
            $body = $e->getResponse()?->getBody()?->getContents();
            throw new \RuntimeException("Client error ({$e->getCode()}): " . $e->getMessage() . "\nResponse: $body", 0, $e);
        } catch (RequestException $e) {
            // Bắt lỗi 5xx hoặc lỗi kết nối
            $body = $e->getResponse()?->getBody()?->getContents();
            throw new \RuntimeException("Request error ({$e->getCode()}): " . $e->getMessage() . "\nResponse: $body", 0, $e);
        } catch (\Exception $e) {
            // Lỗi không xác định
            throw new \RuntimeException("Unexpected error: " . $e->getMessage(), 0, $e);
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
    public function call(string $endpoint, $method = "get", array $addonOptions = [])
    {
        $response = $this->raw($endpoint, $method, $addonOptions);
        return json_decode($response->getBody()->getContents());
    }


    // Get
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
