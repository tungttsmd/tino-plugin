<?php
class OrderController extends Controller
{
    use BaseService;

    public function run($widget_data, $nameservers, $auth, $config_nameservers, $config_tlds, $msg, $color)
    {

        if (!isset($_POST['button']) || empty($_POST['button'])) {
            $_POST['button'] = "orderOther";
        };
        // Ajax send $_POST ajaxConfirm and domainInput together
        if (!isset($_POST['ajaxConfirm']) && !isset($_GET['invoice'])) {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                OrderAction::make()
                    ->orderFormDraw($widget_data, $config_tlds, $msg, $color);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] === 'orderOther')) {
                OrderAction::make()
                    ->orderFormDraw($widget_data, $config_tlds, $msg, $color);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] === 'orderNew')) {
                # orderNew Có nhả true/false (true = đăng nhập và nhập liệu không có vấn đề)
                OrderAction::make()
                    ->orderNew($_POST['domain'] ?? '', $nameservers, $auth, $widget_data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['button'] === 'orderConfirm') {
                OrderAction::make()
                    ->orderConfirm($nameservers, $auth, $widget_data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['button'] === 'orderPayment') {
                OrderAction::make()
                    ->orderPayment($_POST['domain'] ?? '', $config_nameservers, $auth, $widget_data);
            }
        } elseif (isset($_POST['ajaxConfirm']) && !isset($_GET['invoice'])) {
            return OrderAction::make()
                ->ajaxInvoiceLookupPrint($auth->username, $auth->password, $_POST['domainInput']);
        } else {
            OrderAction::make()
                ->ajaxInvoiceIdPrint($auth->username, $auth->password);
        }
    }

    public function suggestionCell($sld, $tld, $username, $password)
    {
        $info = DomainService::make()->domainLookup($sld . "." . $tld, $username, $password);
        $data = betterStd([
            'price' => $info->tld !== '.vn' ? number_format($info->periods->{'0'}->register ?? '0', 0, ',', '.') : '450.000',
            'domain' => $info->domain ?? '0',
            'status' => $info->status ?? 0,
            'tld' => $info->tld,
            'sld' => $info->sld
        ]);
        ob_start();
        $this->render('widget_suggestion_cell', $data);
        return ob_get_flush();
    }
    public function suggestionGetSld($domainInput, $username, $password)
    {
        $info = DomainService::make()->domainLookup($domainInput, $username, $password);
        return ['sld' => $info->sld];
    }
}
