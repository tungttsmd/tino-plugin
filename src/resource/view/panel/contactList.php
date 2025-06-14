<div id="tino-container">
    <div id="spinnerDivCenter">
        <div id="spinner"></div>
    </div>

    <div class="tab-buttons">
        <a href="?tab=order">
            <button type="button">Danh sách đặt hàng</button>
        </a>
        <a href="?tab=contact">
            <button class="active" type="button">Danh sách liên hệ</button>
        </a>
    </div>

    <div id="alertBox" class="alert alert-info fade show">
        Danh sách liên hệ được tải thành công.
        <button class="alertClose" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>

    <!-- start: ajax html replacer -->
    <div id="ajaxHtmlReplacer" class="contactList">
        <div class="uiBlock" style="display: flex; flex-direction:column;margin-bottom: 20px;">
            <!-- Ô tìm kiếm được gán ID để xử lý -->
            <input id="searchInput" type="text" placeholder="Tìm kiếm liên hệ..." style="flex: 1; padding: 8px;" />
            <button class="button-pretty" onclick="alert('Tạo liên hệ mới')">+ Tạo mới</button>

            <table style="margin-top:20px;width: 100%; border-collapse: collapse; font-family: sans-serif; table-layout: fixed;">
                <thead style="background-color: #f5f5f5;">
                    <tr>
                        <th style="padding: 10px; border: 1px solid #ccc;">Access_ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Parent_ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Client_ID</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Họ tên</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Email</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Trạng thái</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Ngày tạo</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $contact): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <?= htmlspecialchars($contact->id) ?>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <?= htmlspecialchars($contact->parent_id) ?>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <?= htmlspecialchars($contact->client_id) ?>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <?= htmlspecialchars($contact->name) ?>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <?= htmlspecialchars($contact->email) ?>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <span class="alert <?= $contact->status === 'Active' ? 'alert-success' : 'alert-danger' ?>" style="padding: 4px 10px;">
                                    <?= htmlspecialchars($contact->status) ?>
                                </span>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <?= date('Y-m-d', strtotime($contact->datecreated)) ?>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ccc;">
                                <div class="button-wrapper" style="width: 100%">
                                    <a style="width: 100%" href="?tab=contact&detail=<?= htmlspecialchars($contact->id) ?>" target="_blank">
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