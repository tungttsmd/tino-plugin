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
    public function getEkycUrl($order_id)
    {
        $document = $this->call("domain/" . $order_id . "/documents", "get", []);
        return "https://kyc.info.vn/ekyc.php?token=" . $document->token;
    }
    public function getDocuments($order_id)
    {
        $document = $this->call("domain/" . $order_id . "/documents", "get", []);
        return $document->documents;
    }
    public function getDocumentById($order_id, $document_id)
    {
        $document = $this->call("domain/" . $order_id . "/documents", "get", []);
        foreach ($document->documents as $value) {
            if ($value->id === $document_id) {
                return $value;
            }
        }
        return null;
    }
    public function getDocumentUploaded($order_id)
    {
        $document = $this->call("domain/" . $order_id . "/documents", "get", []);
        $list = [];
        foreach ($document->documents as $value) {
            if (is_null($value)) {
                continue;
            }
            $list[$value->id]['name'] = $value->name;
            $list[$value->id]['isUpload'] = $value->uploaded;
        };
        return $list;
    }
    public function getDocumentListId($order_id)
    {
        $document = $this->call("domain/" . $order_id . "/documents", "get", []);
        $list = [];
        foreach ($document->documents as $value) {
            $list[$value->id] = $value->name;
        };
        return $list;
    }
}
