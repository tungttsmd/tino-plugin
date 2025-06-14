<div id="tino-container">
    <div id="spinnerDivCenter">
        <div id="spinner"></div>
    </div>

    <div class="tab-buttons">
        <a href="?tab=order">
            <button class="active" type="button">Danh sách đặt hàng</button>
        </a>
        <a href="?tab=contact">
            <button type="button">Danh sách liên hệ</button>
        </a>
    </div>

    <div id="alertBox" class="alert alert-info fade show">
        Danh sách domain được tải thành công.
        <button class="alertClose" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>

    <div id="ajaxHtmlReplacer" class="orderList">
        <div class="uiBlock" style="display: flex; flex-direction: column; margin-bottom: 20px;">
            <input id="searchInput" type="text" placeholder="Tìm kiếm domain..." style="flex: 1; padding: 8px;" />
            <button class="button-pretty" onclick="alert('Tạo domain mới')">+ Tạo mới</button>

            <table style="margin-top:20px; width: 100%; border-collapse: collapse; font-family: sans-serif; table-layout: fixed;">
                <thead style="background-color: #f5f5f5;">
                    <tr>
                        <th style="padding: 10px; border: 1px solid #ccc;">ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Tên domain</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Hạn dùng</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Đuôi miền</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Trạng thái</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Số tiền</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Ngày tạo</th>
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
                                    <a style="width: 100%" href="?tab=order&detail=<?= urlencode($domain->id) ?>" target="_blank">
                                        <button style="width: 100%" class="button-outline">Xem</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>