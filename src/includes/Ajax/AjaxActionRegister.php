<?php

namespace Includes\Ajax;

use App\Actions\OrderAction;
use App\Controllers\AjaxController;
use App\Controllers\OrderController;
use Model\Auth;

class AjaxActionRegister
{
    public function __construct()
    {
        add_action('wp_ajax_ajaxInvoiceInspect', [$this, 'ajaxInvoiceInspect_callback']);
        add_action('wp_ajax_nopriv_ajaxInvoiceInspect', [$this, 'ajaxInvoiceInspect_callback']); // Dành cho người dùng không đăng nhập
        add_action('wp_ajax_ajaxDomainInspect', [$this, 'ajaxDomainInspect_callback']);
        add_action('wp_ajax_nopriv_ajaxDomainInspect', [$this, 'ajaxDomainInspect_callback']); // Dành cho người dùng không đăng nhập
        add_action('wp_ajax_ajaxDomainToOrder', [$this, 'ajaxDomainToOrder_callback']);
        add_action('wp_ajax_nopriv_ajaxDomainToOrder', [$this, 'ajaxDomainToOrder_callback']); // Dành cho người dùng không đăng nhập
    }
    # Lấy return
    // public function MOTHERFUCKER_callback()
    // {
    //     // Xử lý yêu cầu AJAX ở đây
    //     //////////////////////////////////////////////////////////////////
    //     # Load file cấu hình
    //     require PLUGIN_PATH . 'src/system/autoload.php';

    //     # Lấy dữ liệu
    //     $configData = [
    //         $_POST['domainInput'] ?? '',
    //         CONFIG_NAMESERVERS,
    //         CONFIG_USERNAME,
    //         CONFIG_PASSWORD
    //     ];

    //     # Khởi tạo, nén dữ liệu
    //     $action = OrderAction::make()
    //         ->orderInit(...$configData);

    //     # Giải nén dữ liệu
    //     extract($action); # $color, $widget, $nameserver, $auth, $msg, $flag đều nằm đây

    //     $programData = [
    //         $widget_data,
    //         $nameservers,
    //         $auth,
    //         CONFIG_NAMESERVERS,
    //         $msg,
    //         $color
    //     ];
    //     # Xử lý và thực thi chương trình
    //     $invoiceID = OrderController::make()->run(...$programData);
    //     ////////////////////////////////////////////////////////////////

    //     // if (isset($_POST['ajaxConfirm']) && $_POST['ajaxConfirm'] == 'true') {
    //     // Gửi lại kết quả
    //     wp_send_json(array('invoiceID' => $invoiceID ?? '', 'hoadonUrl' => $config_invoiceDraw ?? ''));
    //     // }
    // }
    
    public function ajaxInvoiceInspect_callback()
    {
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        $ajax = new AjaxController();
        $invoiceID = $ajax->invoiceLookup($auth->token(),  $_POST['domain']);
        wp_send_json(array("invoiceID" => $invoiceID, "domain" => $_POST['domain'], 'invoicePrintUrl' => CONFIG_INVOICE_PRINT_URL));
    }
    public function ajaxDomainInspect_callback()
    {
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        $ajax = new AjaxController();
        $domainInspect = $ajax->domainInspect($auth->token(),  $_POST['domain'], CONFIG_NAMESERVERS);
        wp_send_json(array("domainInspect" => $domainInspect));
    }
    public function ajaxDomainToOrder_callback()
    {
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        $ajax = new AjaxController();
        $domainToOrder = $ajax->domainToOrder($auth->token(),  $_POST['domain'], CONFIG_NAMESERVERS);
        wp_send_json(array("domainToOrder" => $domainToOrder));
    }
}
