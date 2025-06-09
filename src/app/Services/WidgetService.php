<?php
namespace App\Services;

use App\Helper\BaseService;
class WidgetService
{
    use BaseService;

    public function widgetImportData($domainName, $nameservers, $auth)
    {
        return betterStd(['data' => ['domain' => trim($domainName), 'nameservers' => $nameservers,], 'login' => (array) $auth]);
    }
    public function widgetAlert($lookup)
    {
        return betterStd([
            'domain' => $lookup->name,
            'sld' => $lookup->sld,
            'tld' => $lookup->tld,
            'isOwned?' => !$lookup->avaliable,
            'tld_id' => $lookup->tld_id,
            'years' => $lookup->periods->{0}->period,
            # Tên miền .vn ở khi fetch từ tino ra giá 57K? -> cần fix lại 450.000 theo bảng giá Tino
            'payment_total' => number_format($lookup->tld === '.vn' ? "450000" : $lookup->periods->{0}->register, 0, ',', '.'),
        ]);
    }
}
