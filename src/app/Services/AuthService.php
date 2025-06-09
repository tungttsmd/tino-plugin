<?php
namespace App\Services;

use App\Helper\BaseService;

class AuthService
{
    use BaseService;
    public function lookup($dangkytenmien, $data)
    {
        return $dangkytenmien->lookup($data->domain);
    }
}
