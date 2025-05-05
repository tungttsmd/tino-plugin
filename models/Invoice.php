<?php

class Invoice extends ApiClient
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
        $this->baseUrl = Config::tino()->baseUrl;
        $this->header = [
            'Authorization: Bearer ' . $this->token
        ];
        # parent construct
        parent::__construct($this->baseUrl, $this->header, $this->timeout, $this->sslVerify);
    }

    # get invoice full info
    public function fetch($id): object
    {
        $endpoint = "invoice/$id";
        $data = $this->get($endpoint, []);
        return \Config::convertStd(json_decode($data['response']));
    }
    # get list invoice
    public function list()
    {
        $endpoint = "invoices";
        $data = $this->get($endpoint);
        return \Config::convertStd(json_decode($data['response'])->invoices);
    }
    # list invoice id
    public function listId()
    {
        $data = $this->list();
        $list = [];
        foreach ($data as $key => $value) {
            $list[] = $value->id;
        }
        return $list;
    }
    # echo print invoice HTML 
    public function fetchHtml(int $id): string
    {
        return $this->fetch($id)->invoicebody;
    }
    # get list payment method
    public function paymentMethods(): object
    {
        $endpoint = "payment";
        $data = $this->get($endpoint, []);
        $list = json_decode($data['response'])->payments;
        if ($list->{43}) unset($list->{43}); # gateway_id = 43 not used by server ever, so avoiding wrong using, unset it
        return $list;
    }

    # give payment link
    private function paymentLinkHref(int $invoice_id, int $gateway_id, $start_needle = '', $end_needle = '')
    {
        $html = $this->paymentLinkHtml($invoice_id, $gateway_id);
        # simple element to find
        $start_pos = strpos($html, $start_needle);
        $end_pos = strpos($html, $end_needle);
        # not set start_needle & end_needle to get full html
        if ($start_needle || $end_needle) {
            $link = substr($html, $start_pos, $end_pos - ($start_pos));
        } else {
            $link = substr($html, 0);
        }
        return $link;
    }
    # echo print invoice HTML 
    public function paymentLinkHtml(int $invoice_id, int $gateway_id = 71): string
    {
        $endpoint = "/billing/$invoice_id/pay/$gateway_id";
        $data = $this->get($endpoint, []);
        return json_decode(json: $data['response'])->content;
    }
    public function paymentVNPayHref(int $invoice_id)
    {
        $link = $this->paymentLinkHref($invoice_id, 71, "https://pay.vnpay.vn", "'>Thanh toán ngay qua VNPAY");
        return $link;
    }
    public function paymentMomoHref(int $invoice_id)
    {
        $link = $this->paymentLinkHref($invoice_id, 70, "https://payment.momo.vn", "' class='");
        return $link;
    }

    // XOÁ THẤT BẠI - CHƯA RÕ LÍ DO
    # delete invoice
    public function deleteInvoice(int $id)
    {
        $endpoint = "invoice/$id";
        $data = $this->delete($endpoint, []);
        return $data;
    }
}
