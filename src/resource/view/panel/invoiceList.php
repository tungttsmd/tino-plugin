<div class="uiBlock invoiceList" style="display: flex; flex-direction: column; margin-bottom: 20px;">
    <table style="width: 100%; border-collapse: collapse; font-family: sans-serif; margin-top: 20px;">
        <thead style="background-color: #f5f5f5;">
            <tr>
                <th onclick="sortTable(this, 0, 'number')" style="padding: 10px; border: 1px solid #ccc;">Mã hoá đơn</th>
                <th onclick="sortTable(this, 1, 'date')" style="padding: 10px; border: 1px solid #ccc;">Ngày tạo</th>
                <th onclick="sortTable(this, 2, 'date')" style="padding: 10px; border: 1px solid #ccc;">Ngày đến hạn</th>
                <th onclick="sortTable(this, 3, 'number')" style="padding: 10px; border: 1px solid #ccc;">Tổng tiền (VND)</th>
                <th onclick="sortTable(this, 4, 'string')" style="padding: 10px; border: 1px solid #ccc;">Trạng thái</th>
                <th onclick="sortTable(this, 5, 'number')" style="padding: 10px; border: 1px solid #ccc;">Số hoá đơn</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $invoice): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ccc;">
                        <?= htmlspecialchars($invoice->id) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ccc;">
                        <?= htmlspecialchars($invoice->date) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ccc;">
                        <?= htmlspecialchars($invoice->duedate) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: right;">
                        <?= number_format((float)$invoice->total, 0, ',', '.') ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ccc;">
                        <span class="alert <?= $invoice->status === 'Unpaid' ? 'alert-warning' : ($invoice->status === 'Paid' ? 'alert-success' : 'alert-danger') ?>" style="padding: 4px 10px;">
                            <?= htmlspecialchars($invoice->status) ?>
                        </span>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ccc;">
                        <?= htmlspecialchars($invoice->number) ?>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ccc; text-align: center;">
                        <div class="button-wrapper" style="width: 100%">
                            <button type="button" onclick="loadpage('invoice','<?= htmlspecialchars($invoice->id) ?>', '#ajaxHtmlReplacer')" style="width: 100%" class="button-outline">Xem</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="7" style="text-align:center; padding:20px;">Không có hoá đơn nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>