<?php
namespace models;

use System\ApiClient;

class Tld extends ApiClient
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

    public function fetchAll()
    {
        $endpoint = Config::tino()->pricing->endpoint;
        $data = $this->get($endpoint, []);
        return Config::convertStd(json_decode($data['response']));
    }
    public function list()
    {
        $data = $this->fetchAll();
        $list = [];
        foreach ($data->tlds as $key => $value) {
            $tld = $value->tld;
            $transfer = $value->periods->{'0'}->transfer;
            $register = $value->periods->{'0'}->register;
            $renew = $value->periods->{'0'}->renew;
            $list[$key] = [
                'tld' => $tld,
                'register' => ceil($register),
                'transfer' => $transfer > 0 ? ceil($transfer) : 'Miễn phí',
                'renew' => ceil($renew),
            ];
        }
        return Config::convertStd($list);
    }

    # table printing
    public function pricingHtml()
    {
        try {
            $list = $this->list();
            ob_start();
            include(betterPath(__FILE__,1) . 'views/widget_pricing.php');
            $html = ob_get_flush();
            return $html;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
