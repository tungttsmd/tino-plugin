<?php

namespace Model;

use GuzzleHttp\Exception\GuzzleException;
use Helper\Maker;
use Repository\ApiClient;
use RuntimeException;

class DummyAPI extends ApiClient
{
    use Maker;
    // Constructor
    public function __construct()
    {
        # Class dược phép sử dụng chain method: $this->domainName("abc.com")->refresh()->search()->getId()
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        parent::__construct($auth->token());
    }

    // Init 
    public function apiCall($endpoint, $method, $options)
    {
        return $this->call($endpoint, $method, $options);
    }
    public function apiRaw($endpoint, $method, $options)
    {
        return $this->raw($endpoint, $method, $options);
    }
}
