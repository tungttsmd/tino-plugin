<?php
// LỆNH TRIỂN KHAI AJAX THEO CHUẨN WP: [action name]_callback()
function ajaxRequest_invoiceRender_callback()
{
    require(dirname(dirname(plugin_dir_path(__FILE__))) . '/system/autoload.php');


    // Xử lý yêu cầu AJAX ở đây
    $response = AjaxController::make()
        ->invoiceDraw($_POST['domainInput'] ?? '', $config_nameservers, $config_username, $config_password);

    $data = betterStd($response);
    wp_send_json(array('invoiceID' => $data->invoiceID ?? '', 'hoadonUrl' => $config_invoiceDraw ?? ''));
    // }
};
function ajaxRequest_domainOrder_callback()
{
    require(dirname(dirname(plugin_dir_path(__FILE__))) . '/system/autoload.php');

    // Xử lý yêu cầu AJAX ở đây
    $response = AjaxController::make()
        ->orderDomain($_POST['domainInput'] ?? '', $config_nameservers, $config_username, $config_password);

    $data = betterStd($response);

    # Xử lý và thực thi chương trìnhs
    wp_send_json(array('invoiceID' => $data->response->invoice_id ?? '', 'hoadonUrl' => $config_invoiceDraw ?? ''));
};

function ajaxRequest_domainInspect_callback()
{
    require(dirname(dirname(plugin_dir_path(__FILE__))) . '/system/autoload.php');
    ob_start();
    $json = AjaxController::make()
        ->orderCheckForm($_POST['domainAjax'] ?? '', $config_nameservers, $config_tlds, $config_username, $config_password);
    ob_end_flush();
    wp_send_json($json);
}

function ajaxRequest_suggestionCell_callback()
{
    require(dirname(dirname(plugin_dir_path(__FILE__))) . '/system/autoload.php');
    if (isset($_POST['sld']) && !empty(trim($_POST['sld'])) && $_POST['sld']) {
        // foreach ($config_tlds as $value) {
        ob_start();
        $info = OrderController::make()->suggestionCell($_POST['sld'], $_POST['tld'], $config_username, $config_password);
        ob_get_flush(); // }
    }
    wp_die();
}
function ajaxRequest_suggestionGetSld_callback()
{
    require(dirname(dirname(plugin_dir_path(__FILE__))) . '/system/autoload.php');
    if (isset($_POST['domainInput']) && !empty(trim($_POST['domainInput'])) && $_POST['domainInput']) {
        ob_start();
        $sld = OrderController::make()->suggestionGetSld($_POST['domainInput'], $config_username, $config_password);
        ob_end_flush();
    };
    wp_send_json($sld ?? null);
}
