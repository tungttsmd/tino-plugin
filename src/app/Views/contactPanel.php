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
    <div id="ajaxHtmlReplacer">
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById("searchInput");
        const table = document.querySelector("#ajaxHtmlReplacer table");
        const tbody = table.querySelector("tbody");

        input.addEventListener("keyup", function() {
            const keyword = input.value.toLowerCase().trim();
            const rows = tbody.querySelectorAll("tr");

            rows.forEach(row => {
                const name = row.cells[1].textContent.toLowerCase();
                const email = row.cells[2].textContent.toLowerCase();
                if (name.includes(keyword) || email.includes(keyword)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
</script>
<style>
    th,
    td {
        padding: 10px;
        border: 1px solid #ccc;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-break: break-word;
        max-width: 150px;
        /* Tuỳ chỉnh theo từng cột */
    }

    .tab-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .tab-buttons button {
        padding: 10px 20px;
        border: 1px solid #0073aa;
        background-color: white;
        color: #0073aa;
        cursor: pointer;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .tab-buttons button.active,
    .tab-buttons button:hover {
        background-color: #0073aa;
        color: white;
    }
</style>
</style>