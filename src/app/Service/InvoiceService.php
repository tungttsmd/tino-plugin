<?php

namespace App\Service;

use App\Helper\BaseService;
use Model\Auth;
use Model\Invoice;

class InvoiceService
{
  use BaseService;
  public function invoiceQrDraw($invoiceId)
  {
    $authen = new Auth(CONFIG_USERNAME, password: CONFIG_PASSWORD);
    $invoice = new Invoice($authen->token());
    $invoice->invoice($invoiceId);

    ob_start();

    echo $invoice->getHtml() . "<style>body {width:auto;}</style>";
    echo "
    <style>
    #printView {
      border: 2px solid #444;            
      border-radius: 8px;                
      padding: 20px;                   
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); 
      background-color: #fff;          
      margin-top: 20px;                  
      box-sizing: border-box;
      transition: all 0.3s ease;
    }
    
    #printView:hover {
      box-shadow: 0 0 20px rgba(0, 128, 255, 0.2);
      border-color: #0077cc;
      transition: all 0.3s ease;
    }
    
    /* Hover các dòng bảng sản phẩm */
    #printView table.border tr:hover {
      background-color:rgb(88, 241, 152);  /* Xanh nhạt */
      cursor: pointer;
      transition: background-color 0.2s ease;
      /* Xoá hiệu ứng scale */
    }
    
    /* Hover thông tin khách hàng */
    #printView .VATTEMP table tr:hover {
      background-color: rgb(187, 241, 88);
      transition: background-color 0.3s ease;
    }
    
    /* Hover vùng tổng kết */
    #printView table.border:last-of-type tr:hover {
      background-color: rgb(187, 241, 88);
      transition: background-color 0.2s ease;
    }
    
    /* Hover phần chuyển khoản */
    #printView .invoice-table-transaction tr:hover {
      background-color: rgb(88, 241, 152);
      transition: background-color 0.2s ease;
    }
    
    /* Khi in: bỏ đổ bóng, bo góc, dùng viền rõ ràng */
    @media print {
      #printView {
        border: 1px solid #000;
        box-shadow: none;
        border-radius: 0;
        padding: 15px;
      }
    }
    .invoice-table-transaction > tbody > tr > td:nth-child(1) {
      max-width: 160px !important;
    }
    .invoice-table-transaction td img {
      width: 100% !important;
      height: auto !important;
    }
      </style>";
    return ob_get_clean();
  }
}
