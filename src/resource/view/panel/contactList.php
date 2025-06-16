<div class="uiBlock contactList" style="display: flex; flex-direction:column;margin-bottom: 20px;">
    <table style="margin-top:20px;width: 100%; border-collapse: collapse; font-family: sans-serif; table-layout: fixed;">
        <thead style="background-color: #f5f5f5;">
            <tr>
                <th onclick="sortTable(this, 0, 'number')" style="padding: 10px; border: 1px solid #ccc;">Access_ID</th>
                <th onclick="sortTable(this, 1, 'number')" style="padding: 10px; border: 1px solid #ccc;">Parent_ID</th>
                <th onclick="sortTable(this, 2, 'number')" style="padding: 10px; border: 1px solid #ccc;">Client_ID</th>
                <th onclick="sortTable(this, 3, 'string')" style="padding: 10px; border: 1px solid #ccc;">Họ tên</th>
                <th onclick="sortTable(this, 4, 'string')" style="padding: 10px; border: 1px solid #ccc;">Email</th>
                <th onclick="sortTable(this, 5, 'string')" style="padding: 10px; border: 1px solid #ccc;">Trạng thái</th>
                <th onclick="sortTable(this, 6, 'date')" style="padding: 10px; border: 1px solid #ccc;">Ngày tạo</th>
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
                            <button type="button" onclick="loadpage('contact','<?= htmlspecialchars($contact->id) ?>', '#ajaxHtmlReplacer')" style="width: 100%" class="button-outline">Xem</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>