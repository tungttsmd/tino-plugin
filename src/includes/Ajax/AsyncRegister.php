<?php

namespace Includes\Ajax;

use Controller\AsyncController;

class AsyncRegister
{
    public function __construct()
    {
        add_action('wp_ajax_ajaxInvoiceInspect', [$this, 'ajaxInvoicePrint_callback']);
        add_action('wp_ajax_nopriv_ajaxInvoiceInspect', [$this, 'ajaxInvoicePrint_callback']); // Dành cho người dùng không đăng nhập
        add_action('wp_ajax_ajaxDomainInspect', [$this, 'ajaxDomainInspect_callback']);
        add_action('wp_ajax_nopriv_ajaxDomainInspect', [$this, 'ajaxDomainInspect_callback']); // Dành cho người dùng không đăng nhập
        add_action('wp_ajax_ajaxDomainToOrder', [$this, 'ajaxDomainToOrder_callback']);
        add_action('wp_ajax_nopriv_ajaxDomainToOrder', [$this, 'ajaxDomainToOrder_callback']); // Dành cho người dùng không đăng nhập
        add_action('wp_ajax_ajaxContactCreate', [$this, 'ajaxContactCreate_callback']);
        add_action('wp_ajax_nopriv_ajaxContactCreate', [$this, 'ajaxContactCreate_callback']); // Dành cho người dùng không đăng nhập
        add_action('wp_ajax_ajaxInvoiceChecker', [$this, 'ajaxInvoiceChecker_callback']);
        add_action('wp_ajax_nopriv_ajaxInvoiceChecker', [$this, 'ajaxInvoiceChecker_callback']); // Dành cho người dùng không đăng nhập
    }

    /**
     * Summary of ajaxInvoicePrint_callback
     * @return void
     * Chức năng:
     * - Lấy dữ liệu ajax phục vụ vẽ hoá đơn
     */
    public function ajaxInvoicePrint_callback()
    {
        $ajax = new AsyncController();
        $invoiceID = $ajax->invoiceIdLookup($_POST['domain']);
        wp_send_json(array("invoiceID" => $invoiceID, "domain" => $_POST['domain'], 'invoicePrintUrl' => CONFIG_INVOICE_PRINT_URL));
    }

    /**
     * Summary of ajaxDomainInspect_callback
     * @return void
     * Chức năng:
     * - Lấy dữ liệu đã xử lý domain inspect về
     */
    public function ajaxDomainInspect_callback()
    {
        $ajax = new AsyncController();
        $domainInspect = $ajax->domainInspect($_POST['domain']);
        wp_send_json($domainInspect);
    }

    /**
     * Summary of ajaxDomainToOrder_callback
     * @return void
     * Chức năng:
     * - Lấy dữ liệu đã xử lý domain order về
     */
    public function ajaxDomainToOrder_callback()
    {
        $ajax = new AsyncController();
        $domainToOrder = $ajax->domainToOrder($_POST['domain'], $_POST['contact_id'], $_POST['nameservers']);
        wp_send_json($domainToOrder);
    }

    public function ajaxContactCreate_callback()
    {
        // Dữ liệu trả về là một json đã bị encode 2 lần, 1 submit form encode (URLparams...) và 1 json string (javascript) endcode
        $_POST['contactInfoPackage'] = json_decode(stripslashes($_POST['contactInfoPackage']), true);

        // Thực thi Async controller
        $ajax = new AsyncController();
        $contactCreateReturn = $ajax->contactCreateNew($_POST['contactInfoPackage']);
        wp_send_json($contactCreateReturn);
    }
    public function ajaxInvoiceChecker_callback()
    {
        $ajax = new AsyncController();
        $invoiceStatus = $ajax->invoiceStatusChecker($_POST['invoice_checker_id']);
        wp_send_json($invoiceStatus);
    }
}
