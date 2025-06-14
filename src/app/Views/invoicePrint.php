    <div id="printView">
        <h2>🧾 Thông tin Hóa đơn</h2>
        <table class="border" style="width: 100%; border-collapse: collapse; margin: 20px auto; font-family: Arial, sans-serif;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center; background-color: #0077cc; color: white; padding: 12px;">
                        🧾 Thông tin thanh toán - Quản lý tên miền Tino.vn
                    </th>
                </tr>
            </thead>
            <tbody class="invoice-table-transaction">
                <tr>
                    <td colspan="2" style="padding: 0; border: none;">
                        <div style="display: flex; width: 100%;">
                            <!-- QR Code -->
                            <div style="border: 1px solid gainsboro;flex: 0 0 360px; display: flex; justify-content: center; align-items: center;">
                                <img
                                    src="https://tino.vn/api/vietqr?account=900967777&bankcode=970422&amount=<?= $invoiceDetail->total ?>&noidung=TNG<?= $invoiceDetail->id ?>"
                                    alt="QR Code Thanh toán"
                                    style="width: 100%; max-width: 260px; object-fit: contain;" />
                            </div>

                            <!-- Nội dung thanh toán -->
                            <div style="flex: 1;">
                                <table class="borderless" style="margin-bottom:10px; width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold; width: 40%;">Ngân hàng</td>
                                        <td style="padding: 8px;">Ngân hàng Quân Đội (MBBANK)</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Số tài khoản</td>
                                        <td style="padding: 8px;"><strong>900967777</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Chủ tài khoản</td>
                                        <td style="padding: 8px;"><strong>CÔNG TY CỔ PHẦN TẬP ĐOÀN TINO</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Nội dung chuyển khoản</td>
                                        <td class="invoiceCheckerId" data-invoice-checker-id="<?= $invoiceDetail->id ?>" style="padding: 8px;">
                                            <strong>TNG<?= $invoiceDetail->id ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Số tiền</td>
                                        <td style="padding: 8px;">
                                            <strong><?= number_format($invoiceDetail->total, 0, '.', ',') ?> đ</strong>
                                        </td>
                                    </tr>
                                </table>
                                <table class="borderless" style="margin-top:10px; margin-bottom: 0px; width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Trạng thái</td>
                                        <td style="padding: 8px;">
                                            <strong style="color: <?= htmlspecialchars($data->status) === 'Paid' ? 'green' : 'red' ?>">
                                                <?= htmlspecialchars($data->status) === 'Paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?>
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Tên miền</td>
                                        <td style="padding: 8px;">
                                            <strong style="color: #007bff;">
                                                <?= htmlspecialchars($data->domain_name) ?>
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Mã đơn hàng</td>
                                        <td style="padding: 8px;">
                                            <strong style="color: #000;">
                                                <?= htmlspecialchars($data->domain_id) ?>
                                            </strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th colspan="2" style="background-color: #f0f0f0; text-align: center; padding: 12px;">🧍‍♂️ Thông tin Khách hàng</th>
                </tr>

                <tr>
                    <td>Họ và tên</td>
                    <td><?= htmlspecialchars($data->client->firstname . ' ' . $data->client->lastname) ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?= htmlspecialchars($data->client->email) ?></td>
                </tr>
                <tr>
                    <td>Số điện thoại</td>
                    <td><?= htmlspecialchars($data->client->phonenumber) ?></td>
                </tr>
                <tr>
                    <td>Cơ quan (nếu là tổ chức)</td>
                    <td><?= htmlspecialchars($data->client->companyname) ?></td>
                </tr>
                <tr>
                    <td>Địa chỉ chi tiết</td>
                    <td><?= htmlspecialchars($data->client->address1) ?></td>
                </tr>
                <tr>
                    <td>Phường/Xã</td>
                    <td><?= htmlspecialchars($data->client->city) ?></td>
                </tr>
                <tr>
                    <td>Tỉnh/Thành phố</td>
                    <td><?= htmlspecialchars($data->client->state) ?></td>
                </tr>
                <tr>
                    <td>Quốc gia</td>
                    <td><?= htmlspecialchars($data->client->country) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <style>
        #printView {
            border: 2px solid #444;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background-color: #fff;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        #printView:hover {
            box-shadow: 0 0 20px rgba(0, 128, 255, 0.2);
            border-color: #0077cc;
        }

        #printView table.border {
            width: 100%;
            border: 1px solid #ccc;
        }

        #printView table.border td,
        #printView table.border th {
            border: 1px solid #ccc;
            padding: 8px;
        }

        #printView .invoice-table-transaction tr:hover {
            background-color: rgb(88, 241, 152);
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        @media print {
            #printView {
                border: 1px solid #000;
                box-shadow: none;
                border-radius: 0;
                padding: 15px;
            }

            body * {
                visibility: hidden;
            }

            #printView,
            #printView * {
                visibility: visible;
            }

            #printView {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }

        table.border th,
        table.border td {
            border: 1px solid #ccc;
        }

        table.border th {
            background-color: #f8f8f8;
        }

        table.border td {
            vertical-align: top;
        }

        @media print {
            table.border {
                border: 1px solid #000;
            }
        }

        table.borderless {
            border-collapse: collapse !important;
            width: 100% !important;
            border: none !important;
        }

        table.borderless td,
        table.borderless th {
            border: 1px solid #ccc !important;
        }

        table.borderless tr:first-child th {
            border-top: none !important;
        }

        /* table.borderless tr:last-child td {
            border-bottom: none !important;
        } */

        table.borderless tr td:first-child,
        table.borderless tr th:first-child {
            border-left: none !important;
        }

        table.borderless tr td:last-child,
        table.borderless tr th:last-child {
            border-right: none !important;
        }
    </style>