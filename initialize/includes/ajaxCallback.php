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
    AjaxController::make()
        ->orderCheckForm($_POST['domainAjax'] ?? '', $config_nameservers, $config_username, $config_password);
    wp_die();
}
