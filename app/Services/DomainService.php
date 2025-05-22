<?php
class DomainService
{
    use BaseService;
    public function lookup($domainObj, $inputDataObj)
    {
        return $domainObj->lookup($inputDataObj->domain);
    }
    public function importCoreData($domainName, $nameservers)
    {
        return betterStd([
            'domain' => trim($domainName),
            'nameservers' => $nameservers,
        ]);
    }
    public function domainLookup($domainName, $username, $password)
    {
        $token = AuthService::make()->getToken($username, $password);
        return Domain::make($token)->lookup($domainName);
    }
}
