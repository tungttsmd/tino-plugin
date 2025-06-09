<?php
namespace models;

use System\ApiClient;

class Domain extends ApiClient
{
    private $header;
    private $timeout;
    private $sslVerify;
    private $baseUrl;
    private $token;
    function __construct($token, array $header_merge = [])
    {
        $this->token = $token;
        # parent config
        $this->timeout = 30;
        $this->sslVerify = false;
        $this->baseUrl = Config::tino()->baseUrl;
        $this->header = array_merge([
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json'
        ], $header_merge); # if want to add json, create this > $variable = Domain($token, ['Content-Type: application/json']) 
        # parent construct
        parent::__construct($this->baseUrl, $this->header, $this->timeout, $this->sslVerify);
    }

    # get domain info with domain id on your account
    public function fetch(int $id)
    {
        $endpoint = "domain/$id";
        $data = $this->get($endpoint, []);
        return betterStd(json_decode($data['response']));
    }
    # full list of pending/paid domains on your account
    public function list()
    {
        $endpoint = "domain";
        $data = $this->get($endpoint, []);
        return betterStd(json_decode($data['response'])); # is mix arrray & stdClass);
    }
    # get domain info by name
    public function fetchByName($domainName)
    {
        $endpoint = "domain/name/$domainName";
        $data = $this->get($endpoint, []);
        return betterStd(json_decode($data['response']));
    }
    # list of pending domain on your account
    public function listPending()
    {
        $listPending = $this->list()->domains;
        foreach ($listPending as $key => $value) {
            if ($value->status !== 'Pending') {
                unset($listPending->{$key});
            }
        }
        return betterStd($listPending);
    }
    # list of paid domain on your account
    public function listPaid()
    {
        $listPending = $this->list()->domains;
        foreach ($listPending as $key => $value) {
            if ($value->status === 'Pending') {
                unset($listPending->{$key});
            }
        }
        return betterStd($listPending);
    }
    # listPending but only get domain id => domain name on your account
    public function listPendingIdName()
    {
        $listPending = $this->listPending();

        # Get name only
        $listPendingName = new \stdClass;
        foreach ($listPending as $key => $value) {
            $listPendingName->{$value->id} = $value->name;
        }
        return $listPendingName;
    }
    # list of all domain id on your account
    public function listId()
    {
        $listPendingIdName = $this->listPendingIdName();
        $listId = [];
        foreach ($listPendingIdName as $key => $value) {
            $listId[] = $key;
        }
        return betterStd($listId);
    }
    # list of all domain name on your account
    public function listName()
    {
        $listPendingIdName = $this->listPendingIdName();
        $listName = [];
        foreach ($listPendingIdName as $key => $value) {
            $listName[] = $value;
        }
        return betterStd($listName);
    }
    # get nameserver
    public function getNameserver(int $id)
    {
        $endpoint = "domain/$id/ns";
        $data = $this->get($endpoint, []);
        return Config::convertStd(json_decode($data['response'])->nameservers);
    }
    # lookup domain for available
    public function lookup(string $domainName)
    {
        $endpoint = 'domain/lookup';
        $data = $this->post($endpoint, ['name' => $domainName]);
        return betterStd(json_decode($data['response']));
    }
    # check available of domain name for order new
    public function isOwned(string $domainName)
    {
        if (isset($this->lookup($domainName)->status)) {
            return (bool) !$this->lookup($domainName)->status;
        } else {
            return null;
        }
    }
    # Check domain name exist on your list domain
    public function domainNameExist(string $domainName)
    {
        $listName = $this->listName();
        foreach ($listName as $value) {
            if ($domainName === $value) {
                return true;
            }
        }
        return false;
    }
    # get tld_id by DomainNAme
    public function getTldId(string $domainName)
    {
        if (isset($this->lookup($domainName)->tld_id)) {
            return $this->lookup($domainName)->tld_id;
        } else {
            return null;
        }
    }
    # order new
    public function order(string $domainName, $gateway_id, object|array $nameservers)
    {
        if ($this->isOwned($domainName)) {
            return false;
        };
        $endpoint = '/domain/order';
        $data = $this->post($endpoint, [
            'name' => $domainName,
            'years' => '1',
            'action' => 'register',
            'tld_id' => $this->getTldId($domainName),
            'payment_method' => $gateway_id,
            'nameservers' => (array) $nameservers, # cho phép $nameservers input là stdClass hoặc array -> tăng linh hoạt
        ]);
        return betterStd($data);
    }

    // PHẢN HỒI THÀNH CÔNG NHƯNG KIỂM TRA THÌ KHÔNG THAY ĐỔI
    # update nameserver
    public function updateNameserver(int $id, array $nameservers)
    {
        $endpoint = "domain/$id/ns";
        $data = $this->put($endpoint, $nameservers);
        return $data;
    }
    # register nameserver
    public function registerNameservers(int $id)
    {
        $endpoint = "domain/$id/reg";
        $data = $this->post($endpoint, []);
        return $data;
    }
}
