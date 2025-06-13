<?php
namespace System;
class ApiClient {
    private $baseUrl;
    private $headers;
    private $timeout;
    private $sslVerify; # disable verify SSL

    function __construct($baseUrl, $headers = [], $timeout = 30, $sslVerify = true) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->headers = $headers;
        $this->timeout = $timeout;
        $this->sslVerify = $sslVerify;
    }

    # define what data type sending in header (Content-Type) is (json, xml, default form...)
    # Nâng cấp (json, xml...) ở đây
    private function requestFormatType() {
        foreach ($this->headers as $header) {
            if (stripos($header, 'content-type') !== false) {
                # is Json?
                if (stripos($header, 'application/json') !== false) {
                    return 'json';
                } 
                # default is query string
                else {
                    return 'queryString';
                }
            }
        }
        return 'queryString';
    }

    # core function
    private function request($method, $url, array $data = []) {
        $ch = curl_init();

        # config request cUrl
        curl_setopt_array($ch, [
            CURLOPT_URL => $url, # URL wanna request
            CURLOPT_RETURNTRANSFER => true, # return value, not print on CLI mode (Command Line Interface)
            CURLOPT_TIMEOUT => $this->timeout, # avoiding infinity request waiting
            CURLOPT_FOLLOWLOCATION => true, # auto redirecting by server request
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $this->headers # this only accept array type with no array key, value = "key: value" ~ "Authorization: Bearer" . token...
        ]);

        # disable verify SSL
        if ($this->sslVerify !== true) { 
            curl_setopt_array($ch, [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0, 
            ]);
        }

        # valid and convert data json/default (query string)
        if ($this->requestFormatType() === 'json') {
            $json_restful_request_data = json_encode($data);
        } else {
            $json_restful_request_data = http_build_query($data); # Succc! Login not use RESTful API!
        };
        # import data request
        if (in_array($method, ['POST', 'PUT', 'DELETE']) && !empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_restful_request_data); # RESTful API always convert php_normal_array -> json_encode(php_normal_array)
        }

        # execute
        $response = curl_exec($ch);
        $debug = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'head' => 'Nội dung phản hồi request',
            'status' => $httpCode,
            'sentData' => $json_restful_request_data, # Restful APi always is sent like json {...} in the body request
            # sent request RESTful API like this string '{"name":"abctest001.com","years":"1","action":"register","tld_id":"346","payment_method":71,"nameservers":["ns.tony.vn","ns.tino.tony"]}'
            'debug' => $debug,
            'response' => $response ? $response : 'Error: can not receive response from server (response = null)',
        ];
    }

    protected function myBaseUrl() {
        return $this->baseUrl;
    }

    protected function get($endpoint, $params = []) {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        if (!empty($params)) {
            $queryString =  http_build_query($params); # makeing URL queryString
            $url .= '?' . $queryString;
        }
        return $this->request('GET', $url);
    }
    protected function post($endpoint, $data = []) {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        return $this->request('POST', $url, $data);
    }
    protected function put($endpoint, $data = []) {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        return $this->request('PUT', $url, $data);
    }
    protected function delete($endpoint, $data = []) {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        return $this->request('DELETE', $url, $data);
    }
}