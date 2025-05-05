<?php

class Pricing extends Tld
{
    private $header;
    private $timeout;
    private $sslVerify;
    private $baseUrl;
    function __construct()
    {
        # parent config
        $this->timeout = 30;
        $this->sslVerify = false;
        $this->baseUrl = \Config::tino()->pricing->baseUrl;
        $this->header = [];
        # parent construct
        parent::__construct($this->baseUrl, $this->header, $this->timeout, $this->sslVerify);
    }
    # In bảng giá
    public function draw()
    {
        return $this->pricingHtml();
    }
}
