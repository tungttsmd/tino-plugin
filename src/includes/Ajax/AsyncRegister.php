<?php

namespace Includes\Ajax;

use Controller\AsyncController;

class AsyncRegister
{
    public function __construct()
    {
        add_action('wp_ajax_ajaxDomainInspect', [$this, 'ajaxDomainInspect_callback']);
        add_action('wp_ajax_nopriv_ajaxDomainInspect', [$this, 'ajaxDomainInspect_callback']); // Dành cho người dùng không đăng nhập
        add_action('wp_ajax_ajaxDomainToOrder', [$this, 'ajaxDomainToOrder_callback']);
        add_action('wp_ajax_nopriv_ajaxDomainToOrder', [$this, 'ajaxDomainToOrder_callback']); // Dành cho người dùng không đăng nhập
        add_action('wp_ajax_ajaxContactCreate', [$this, 'ajaxContactCreate_callback']);
        add_action('wp_ajax_nopriv_ajaxContactCreate', [$this, 'ajaxContactCreate_callback']); // Dành cho người dùng không đăng nhập
        add_action('wp_ajax_ajaxInvoiceChecker', [$this, 'ajaxInvoiceChecker_callback']);
        add_action('wp_ajax_nopriv_ajaxInvoiceChecker', [$this, 'ajaxInvoiceChecker_callback']); // Dành cho người dùng không đăng nhập
    }

    public function ajaxDomainInspect_callback()
    {
        wp_send_json(AsyncController::make()->fetchDomainInspect());
    }

    public function ajaxDomainToOrder_callback()
    {
        wp_send_json(AsyncController::make()->fetchDomainToOrder());
    }

    public function ajaxContactCreate_callback()
    {
        wp_send_json(AsyncController::make()->fetchContactCreate());
    }

    public function ajaxInvoiceChecker_callback()
    {
        wp_send_json(AsyncController::make()->fetchInvoiceInspect());
    }
}
