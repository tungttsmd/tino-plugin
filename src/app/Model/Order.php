<?php

namespace Model;

use Helper\Maker;
use Repository\ApiClient;
use RuntimeException;

class Order extends ApiClient
{
    use Maker;

    // Constructor
    public function __construct()
    {
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        parent::__construct($auth->token());
    }
    public function fetchOrderList()
    {
        try {
            $endpoint = "domain";
            $response = $this->call($endpoint, 'get');
            return $response;
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or domain name is not exist in domain lis searched");
        }
    }
    public function fetchOrderDetail(string|int $order_id)
    {
        try {
            $endpoint = "domain/" . (string) $order_id;
            $response = $this->call($endpoint, 'get');
            return $response;
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or domain name is not exist in domain lis searched");
        }
    }
    public function getOrderContactById(string|int $order_id)
    {
        try {
            $endpoint = "domain/" . (string) $order_id . "/contact";
            $response = $this->call($endpoint, 'get');
            return $response;
        } catch (\Throwable $e) {
            throw new RuntimeException("Domain data invalid or domain name is not exist in domain lis searched");
        }
    }
}
