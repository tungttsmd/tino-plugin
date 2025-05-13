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
}
