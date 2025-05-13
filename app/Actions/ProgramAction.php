<?php
class ProgramAction
{
    use BaseService;

    public function run($widget_data, $nameservers, $auth, $config_nameservers)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            OrderAction::make()
                ->orderFormDraw($widget_data);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] === 'orderOther')) {
            OrderAction::make()
                ->orderFormDraw($widget_data);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] === 'orderNew')) {
            OrderAction::make()
                ->orderNew($_POST['domain'] ?? '', $nameservers, $auth, $widget_data);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['button'] === 'orderConfirm') {
            OrderAction::make()
                ->orderConfirm($config_nameservers, $auth, $widget_data);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['button'] === 'orderPayment') {
            OrderAction::make()
                ->orderPayment($_POST['domain'] ?? '', $config_nameservers, $auth, $widget_data);
        }
    }
}
