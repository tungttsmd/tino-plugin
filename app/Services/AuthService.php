<?php
class AuthService
{
    use BaseService;
    public function lookup($dangkytenmien, $data)
    {
        return $dangkytenmien->lookup($data->domain);
    }
}
