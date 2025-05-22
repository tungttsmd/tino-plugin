<?php
class AuthService
{
    use BaseService;
    public function getToken($username, $password)
    {
        $dangnhap = new Login($username, $password);
        return $dangnhap->getToken();
    }
}
