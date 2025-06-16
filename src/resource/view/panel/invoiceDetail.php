<div class="formEdit" style="font-family: Arial, sans-serif; margin: 20px auto;padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
    <div class="button-wrapper" style="display: flex; width: 100%; margin-bottom: 20px">
        <h3 style="width: 100%"><b>🧾 Hóa đơn chi tiết</b></h3>
        <button onclick="loadpage('invoice',null,'#ajaxHtmlReplacer')" type="button" style="width: 100%" class="button-outline">Quay lại danh sách liên hệ</button>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <th style="text-align: left; width: 200px">Mã hóa đơn:</th>
            <td style="color: blue"><b><?= htmlspecialchars($data->invoice_id) ?></b></td>
        </tr>
        <tr>
            <th>Mã đơn hàng:</th>
            <td style="color: orange"><b><?= htmlspecialchars($data->order_id) ?></b></td>
        </tr>
        <tr>
            <th>Trạng thái:</th>
            <td style="color: <?= $data->invoice_status === 'Paid' ? 'green' : 'red' ?>;"><?= $data->invoice_status === 'Paid' ? 'Đã thanh toán' : 'Chưa thanh toán' ?></td>
        </tr>
        <tr>
            <th>Ngày thanh toán:</th>
            <td><?= htmlspecialchars($data->invoice_paid_date) ?></td>
        </tr>
        <tr>
            <th>Phương thức:</th>
            <td><?= htmlspecialchars($data->invoice_payment->method) ?></td>
        </tr>
        <tr>
            <th>Mã giao dịch:</th>
            <td><?= htmlspecialchars($data->invoice_payment->transaction_id) ?></td>
        </tr>
        <tr>
            <th>Tổng tiền:</th>
            <td><?= number_format($data->invoice_total, 0, ',', '.') ?> đ</td>
        </tr>
    </table>

    <h3>📦 Chi tiết dịch vụ</h3>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="text-align: left; padding: 8px;">Mô tả</th>
                <th style="text-align: right; padding: 8px;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->pricing as $item): ?>
                <tr>
                    <td style="padding: 8px;"><?= htmlspecialchars($item['description']) ?></td>
                    <td style="text-align: right; padding: 8px;"><?= number_format((float)$item['amount'], 0, ',', '.') ?> đ</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>👥 Thông tin liên hệ</h3>
    <?php
    $roles = [
        'registrant' => 'Người đăng ký',
        'admin' => 'Liên hệ quản trị',
        'tech' => 'Kỹ thuật',
        'billing' => 'Thanh toán',
    ];
    foreach ($roles as $key => $label):
        $info = $data->client->$key;
    ?>
        <fieldset style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            <legend style="font-weight: bold;"><?= $label ?></legend>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="text-align: left; width: 200px;">Họ tên:</th>
                    <td><?= htmlspecialchars($info->firstname . ' ' . $info->lastname) ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?= htmlspecialchars($info->email) ?></td>
                </tr>
                <tr>
                    <th>Số điện thoại:</th>
                    <td><?= htmlspecialchars($info->phonenumber) ?></td>
                </tr>
                <tr>
                    <th>Địa chỉ:</th>
                    <td><?= htmlspecialchars($info->address1) ?>, <?= htmlspecialchars($info->city) ?>, <?= htmlspecialchars($info->state) ?>, <?= htmlspecialchars($info->country) ?></td>
                </tr>
                <tr>
                    <th>Contact ID:</th>
                    <td><?= htmlspecialchars($info->contactid) ?></td>
                </tr>
            </table>
        </fieldset>
    <?php endforeach; ?>
</div>