<?php
namespace models;

use System\ApiClient;

class Ticket extends ApiClient
{
    private $header;
    private $timeout;
    private $sslVerify;
    private $baseUrl;
    private $token;
    function __construct($token)
    {
        $this->token = $token;
        # parent config
        $this->timeout = 30;
        $this->sslVerify = false;
        $this->baseUrl = Config::tino()->pricing->baseUrl;
        $this->header = [
            'Authorization: Bearer ' . $this->token
        ];
        # parent construct
        parent::__construct($this->baseUrl, $this->header, $this->timeout, $this->sslVerify);
    }

    public function list()
    {
        $endpoint = 'tickets';
        $data = $this->get($endpoint, []);
        return betterStd(json_decode($data['response']));
    }
}
