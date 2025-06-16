<div class="uiBlock orderList" style="display: flex; flex-direction: column; margin-bottom: 20px;">
    <table style="margin-top:20px; width: 100%; border-collapse: collapse; font-family: sans-serif; table-layout: fixed;">
        <thead style="background-color: #f5f5f5;">
            <tr>
                <th onclick="sortTable(this, 0, 'number')" style="padding: 10px; border: 1px solid #ccc;">ID</th>
                <th onclick="sortTable(this, 1, 'string')" style="padding: 10px; border: 1px solid #ccc;">Tên domain</th>
                <th onclick="sortTable(this, 2, 'date')" style="padding: 10px; border: 1px solid #ccc;">Hạn dùng</th>
                <th onclick="sortTable(this, 3, 'string')" style="padding: 10px; border: 1px solid #ccc;">Đuôi miền</th>
                <th onclick="sortTable(this, 4, 'string')" style="padding: 10px; border: 1px solid #ccc;">Trạng thái</th>
                <th onclick="sortTable(this, 5, 'number')" style="padding: 10px; border: 1px solid #ccc;">Số tiền</th>
                <th onclick="sortTable(this, 6, 'date')" style="padding: 10px; border: 1px solid #ccc;">Ngày tạo</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $domain): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ccc;"><?= htmlspecialchars($domain->id) ?></td>
                    <td style="padding: 10px; border: 1px solid #ccc;"><?= htmlspecialchars($domain->name) ?></td>
                    <td style="padding: 10px; border: 1px solid #ccc;"><?= htmlspecialchars($domain->expires) ?></td>
                    <td style="padding: 10px; border: 1px solid #ccc;"><?= htmlspecialchars($domain->tld) ?></td>
                    <td style="padding: 10px; border: 1px solid #ccc;">
                        <span style="margin: 0; padding: 20px 10px" class="alert <?= ($domain->status === 'Active' ? 'alert-success' : 'alert-danger') ?>" style="padding: 4px 10px;">
                            <?= htmlspecialchars($domain->status) ?>
                        </span>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ccc;"><?= htmlspecialchars($domain->recurring_amount) ?></td>
                    <td style="padding: 10px; border: 1px solid #ccc;"><?= htmlspecialchars($domain->date_created) ?></td>
                    <td style="padding: 10px; border: 1px solid #ccc;">
                        <div class="button-wrapper" style="width: 100%">
                            <button type="button" onclick="loadpage('order','<?= htmlspecialchars($domain->id) ?>', '#ajaxHtmlReplacer')" style="width: 100%" class="button-outline">Xem</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>