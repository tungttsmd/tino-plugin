<?php

namespace Model;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Helper\Session;
use Repository\ApiClient;
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
        // 1. Nạp dữ liệu
        $this->authenLogin($username, $password);

        // 2. Xác thực & lưu trữ thông tin xác thực vào Session tái sử dụng
        $this->authenToken();
    }


    // Init
    private function authenLogin($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->baseUri = ApiClient::staticBaseUri();
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
            $sessionTime = session_get("tino_authentication_expired_time");
            if ($flag && (isset($sessionTime) && (time() > $sessionTime))) {
                $flag = false;
                session_remove("tino_authentication"); // Token hết hạn rồi
                session_remove("tino_authentication_expired_time"); // Token hết hạn rồi
            }
            $sessionAuthentication = session_get("tino_authentication");
            if ($flag && (!isset($sessionAuthentication) || !is_object($sessionAuthentication))) {
                $flag = false;
            }
            // B. Logic
            if ($flag) {
                // 0. Tái sử dụng dữ liệu xác thực từ SESSION
                $this->response = session_get("tino_authentication");
            } else {
                // 0. Auth là phương thức cần tự nó xác thực, nên không kế thừa được, gọi apiclient trực tiếp
                try {
                    $response = $this->client->request(strtoupper("post"), ApiClient::staticBaseUri() . "login", [
                        "form_params" => [
                            "username" => $this->username,
                            "password" => $this->password,
                        ]
                    ]);
                    // 2. Lưu dữ liệu đăng nhập
                    $json = $response->getBody()->getContents();
                    $this->response = json_decode($json);
                    session_set("tino_authentication", $this->response);
                    session_set("tino_authentication_expired_time", time() + 5 * 60); // 5 phút mới lấy token mới -> tránh spam token
                } catch (ClientException $e) {
                    // Bắt lỗi 4xx như 401 Unauthorized
                    $body = $e->getResponse()?->getBody()?->getContents();
                    throw new RuntimeException("Client error ({$e->getCode()}): " . $e->getMessage() . "\nResponse: $body", 0, $e);
                } catch (RequestException $e) {
                    // Bắt lỗi 5xx hoặc lỗi kết nối
                    $body = $e->getResponse()?->getBody()?->getContents();
                    throw new RuntimeException("Request error ({$e->getCode()}): " . $e->getMessage() . "\nResponse: $body", 0, $e);
                } catch (Exception $e) {
                    // Lỗi không xác định
                    throw new RuntimeException("Unexpected error: " . $e->getMessage(), 0, $e);
                }
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
        session_remove("tino_authentication");
        return $this;
    }
}
