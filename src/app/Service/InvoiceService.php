<?php

namespace Service;

use Helper\Maker;
use Model\Auth;
use Model\Invoice;

class InvoiceService
{
  use Maker;
  private $auth;
  private $invoiceModel;
  public function __construct()
  {
    $this->invoiceModel = new Invoice();
  }
}
