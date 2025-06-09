<?php

namespace Model;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class Auth
{
    private $response;
    private $client;
    private $username;
    private $password;
    private $sslVerify;
    private $baseUri;

    // Constructor
    public function __construct($username, $password)
    {
        // 1. Khởi tạo session
        Session::make(); // Class có dùng $_SESSION -> khởi tạo

        // 2. Nạp dữ liệu
        $this->authenLogin($username, $password);

        // 3. Xác thực & lưu trữ thông tin xác thực vào Session tái sử dụng
        $this->authenToken();
    }

    // Init
    private function authenLogin($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->baseUri = "https://my.tino.vn/api/";
        $this->sslVerify = false;
        $this->client = new GuzzleClient([
            "verify" => $this->sslVerify,
            "base_uri" => $this->baseUri
        ]);
    }
    private function authenToken()
    {
        try {
            // A. Condition
            $flag = true;
            if ($flag && (isset($_SESSION['tino_authentication_expired_time']) && (time() > $_SESSION['tino_authentication_expired_time']))) {
                $flag = false;  
                unset($_SESSION['tino_authentication']); // Token hết hạn rồi
                unset($_SESSION['tino_authentication_expired_time']);
            }
            if ($flag && (!isset($_SESSION['tino_authentication']) || !is_object($_SESSION['tino_authentication']))) {
                $flag = false;
            }
            // B. Logic
            if ($flag) {
                // 0. Tái sử dụng dữ liệu xác thực từ SESSION
                $this->response = $_SESSION['tino_authentication'];
            } else {
                // 1. Dùng Tino API Endpoint Login để Xác thực
                $endpoint = "login";
                $response = $this->client->post($endpoint, [
                    "form_params" => [
                        "username" => $this->username,
                        "password" => $this->password,
                    ]
                ]);
                // 2. Lưu dữ liệu đăng nhập
                $json = $response->getBody()->getContents();
                $this->response = json_decode($json);
                $_SESSION['tino_authentication'] = $this->response;
                $_SESSION['tino_authentication_expired_time'] = time() + 5 * 60; // 5 phút mới lấy token mới -> tránh spam token
            }
        } catch (GuzzleException $e) {
            // 3. Ném lỗi trong quá trình xác thực
            throw new RuntimeException('Authentication failed: ' . $e->getMessage());
        }
    }

    // Get
    public function fetchAll()
    {
        return $this->response;
    }
    public function token()
    {
        return $this->response->token;
    }
    public function client()
    {
        return $this->response->client;
    }
    public function refresh()
    {
        unset($_SESSION['tino_authentication']);
        return $this;
    }
}
