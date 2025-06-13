<?php

namespace Action;

use Service\InvoiceService;
use Helper\Maker;
use Helper\Tool;
use Service\ContactService;

class RenderAction
{
    use Maker;
    public function inspectFormRender()
    {
        ob_start();
        include dirname(__DIR__, 3) . '/src/app/Views/inspectForm.php';
        return ob_get_clean();
    }
    public function invoiceRender($invoice_id)
    {
        return InvoiceService::make()->invoiceHtml($invoice_id);
    }
    public function confirmForm($data)
    {
        $data = Tool::make()->oopstd($data);
        ob_start();
        include dirname(__DIR__, 3) . '/src/app/Views/confirmForm.php';
        return ob_get_clean();
    }
    public function contactListRender()
    {
        $contact = new ContactService();
        ob_start();
        var_dump($contact->contactList());
        return ob_get_clean();
    }
}
