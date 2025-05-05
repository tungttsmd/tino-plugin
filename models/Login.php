<?php

class Login extends ApiClient {
    private $username;
    private $password;
    private $timeout;
    private $sslVerify;
    private $baseUrl;
    private $header;

    function __construct($username, $password) {
        # auth token
        $this->username = $username;    
        $this->password = $password;
        # parent
        $this->timeout = 30;    
        $this->sslVerify = false;
        $this->baseUrl = Config::tino()->baseUrl;
        $this->header = [];
        parent::__construct($this->baseUrl, $this->header, $this->timeout, $this->sslVerify);
    }

    public function fetch() {
        $endpoint = 'login';
        # not RESTful
        $data = $this->post($endpoint, [
            'username' => $this->username,
            'password' => $this->password
        ]); 
        return json_decode($data['response']);
    }
    public function isLogin() {
        # if token given back, login is always successful!
        return isset($this->fetch()->token);
    }
    public function getToken() {
        if ($this->isLogin()) {
            return $this->fetch()->token;
        } else {
            return null;
        }
    }

}