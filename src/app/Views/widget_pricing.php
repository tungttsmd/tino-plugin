<?php
require dirname(__DIR__, 3) . "/vendor/autoload.php";

use models\Login;
use models\Tld;

require_once(PLUGIN_PATH . 'src/lib/lib.php');
require_once(PLUGIN_PATH . 'src/models/Config.php');
$login = new Login(CONFIG_USERNAME, CONFIG_PASSWORD);
$tld = new Tld($login->getToken());
$list = new \stdClass;
foreach ($tld->fetchAll()->tlds as $key => $value) {
    $tld = $value->tld;
    $transfer = $value->periods->{'0'}->transfer;
    $register = $value->periods->{'0'}->register;
    $renew = $value->periods->{'0'}->renew;
    $list->$key = betterStd([
        'tld' => $tld,
        'register' => number_format(ceil($register), 0, ',', '.') . ' đ',
        'transfer' => $transfer > 0 ? number_format(ceil($transfer), 0, ',', '.') . ' đ' : 'Miễn phí',
        'renew' => number_format(ceil($renew), 0, ',', '.') . ' đ',
    ]);
};
?>
<div class="modern-table-wrapper">
    <div class="table-controls">
        <input type="text" id="searchInput" placeholder="Tìm TLD hoặc giá...">
    </div>

    <div class="modern-table scrollable" style="--rowNumber: <?= CONFIG_TABLE_HEIGHT ?? 1 ?>">
        <table id="domainTable">
            <thead>
                <tr>
                    <th>Đuôi tên miền</th>
                    <th id="priceHeader" style="cursor: pointer;">
                        Giá đăng ký <span id="sortIcon">⬍</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $value) {
                    $rawPrice = floatval(str_replace([',', '.'], '', preg_replace('/[^0-9,\.]/', '', $value->register ?? 0)));

                    $class = '';
                    if ($rawPrice < 300000) {
                        $class = 'cheap';
                    } elseif ($rawPrice <= 500000) {
                        $class = 'medium';
                    } else {
                        $class = 'expensive';
                    }
                ?>
                    <tr class="<?= $class ?>">
                        <td><?= $value->tld ?? '—' ?></td>
                        <td title="Giá đã bao gồm VAT – Thời hạn 1 năm" data-price="<?= $rawPrice ?>">
                            <?= $value->register ?? '—' ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .modern-table-wrapper {
        font-family: 'Roboto', sans-serif;
        padding-right: 13px !important;
    }

    .table-controls {
        margin: 10px 0;
        text-align: right;
    }

    #searchInput {
        width: 100% !important;
        padding: 8px 12px;
        font-size: 14px;
        width: 220px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: center;
    }

    .modern-table {
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.05);
        height: calc(42px * var(--rowNumber));
    }

    .modern-table table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }

    .modern-table thead th {
        position: sticky;
        top: 0;
        background-color: #2e7d32;
        color: white;
        padding: 12px;
        font-size: 16px;
        z-index: 1;
        width: 50%;
    }

    .modern-table tbody td {
        padding: 10px;
        border-bottom: 1px solid #e0e0e0;
        transition: background-color 0.2s ease, transform 0s ease;
        width: 50%;
    }

    .modern-table tbody tr:hover td {
        background-color: white;
        transform: scale(1.4);
    }

    .modern-table tr.cheap td {
        background-color: #e8f5e9;
    }

    .modern-table tr.medium td {
        background-color: #fffde7;
    }

    .modern-table tr.expensive td {
        background-color: #fce4ec;
    }

    .scrollable {
        overflow-y: scroll;
        max-height: calc(42px * var(--rowNumber));
    }

    body {
        margin: 0;
        border: 1px solid #2E7D32;
        padding: 10px;
        border-radius: 8px;
    }
</style>
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('#domainTable tbody tr');

        rows.forEach(row => {
            const tld = row.cells[0].textContent.toLowerCase();
            const price = row.cells[1].textContent.toLowerCase();
            row.style.display = (tld.includes(keyword) || price.includes(keyword)) ? '' : 'none';
        });
    });

    let sortAsc = true;
    document.getElementById('priceHeader').addEventListener('click', function() {
        const table = document.getElementById('domainTable').tBodies[0];
        const rows = Array.from(table.rows);

        rows.sort((a, b) => {
            const priceA = parseFloat(a.cells[1].dataset.price);
            const priceB = parseFloat(b.cells[1].dataset.price);
            return sortAsc ? priceA - priceB : priceB - priceA;
        });

        rows.forEach(row => table.appendChild(row));
        sortAsc = !sortAsc;
        document.getElementById('sortIcon').textContent = sortAsc ? '⬆' : '⬇';
    });
</script>