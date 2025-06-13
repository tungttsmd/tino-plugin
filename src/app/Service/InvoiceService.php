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
  public function invoiceHtml($invoiceId)
  {
    $invoiceDetail = $this->invoiceModel->getInvoiceById($invoiceId);
    ob_start();
    if (isset($invoiceDetail->status) && $invoiceDetail->status === "Unpaid") {
      echo '
        <div id="printView">
          <img src="https://tino.vn/api/vietqr?account=900967777&bankcode=970422&amount=' . $invoiceDetail->total . '&noidung=TNG' . $invoiceDetail->id . '"/>
          <table class="border">
            <thead>
              <tr>
                <th>Nội dung chuyển khoản đối tác quản lý tên miền Tino.vn</th>
              </tr>
            </thead>
            <tbody class="invoice-table-transaction">
              <tr><td>Ngân hàng Quân Đội (MBBANK)</td></tr>
              <tr><td>Số tài khoản: 900967777</td></tr>
              <tr><td>Chủ tài khoản: CÔNG TY CỔ PHẦN TẬP ĐOÀN TINO</td></tr>
              <tr><td>Nội dung: TNG<?=' . $invoiceDetail->id . '?></td></tr>
              <tr><td>Số tiền: ' . number_format($invoiceDetail->total, 0, '.', ',') . ' đ</td></tr>
            </tbody>
        </table>
      ';
    } elseif (isset($invoiceDetail->status) && $invoiceDetail->status === "Cancelled") {
      echo "Hoá đơn đã bị huỷ";
    } else {
      echo "Hoá đơn đã được thanh toán";
    }
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
