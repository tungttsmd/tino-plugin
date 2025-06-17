<div id="tino-container" style="width: 100%">
    <div id="printView" style="width: 1140px; margin: auto">
        <h2>🧾 Thông tin Hóa đơn</h2>
        <table class="border" style="border-collapse: collapse; font-family: Arial, sans-serif;">
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
                                    src="https://tino.vn/api/vietqr?account=900967777&bankcode=970422&amount=<?= $data->total ?>&noidung=TNG<?= $data->id ?>"
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
                                        <td class="invoiceCheckerId" data-invoice-checker-id="<?= $data->id ?>" style="padding: 8px;">
                                            <strong>TNG<?= $data->id ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Số tiền</td>
                                        <td style="padding: 8px;">
                                            <strong><?= number_format($data->total, 0, '.', ',') ?> đ</strong>
                                        </td>
                                    </tr>
                                </table>
                                <table class="borderless" style="margin-top:10px; margin-bottom: 0px; width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Trạng thái</td>
                                        <td style="padding: 8px;">
                                            <strong style="color: <?= ($data->status === 'Paid') ? 'green' : 'red' ?>">
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
                                    <tr>
                                        <td style="padding: 8px; font-weight: bold;">Xác thực Ekyc</td>
                                        <td style="padding: 8px;">
                                            <?php if ($data->ekyc_verify) { ?>
                                                <span>
													
                                                    <b style="color: green">Đã xác thực Ekyc (có bug ở đây $data->ekyc_verify tại sao luôn trả true?)</b>
                                                </span>
                                            <?php } else { ?>
                                                <a href="<?= $data->ekyc_url ?>" target="_blank">
                                                    <button class="button-pretty" style="border-radius: 4px; width: 100%; color: white; background-color: green">Xác thực Ekyc</button>
                                                </a>
                                            <?php }; ?>
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
</div>