<?php
require dirname(__FILE__,  5) . "/vendor/autoload.php";
$data = std(Model\Pricing::make()->getTable());
?>

<div id="tino-iframe">
    <div class="modern-table-wrapper">
        <div class="table-controls">
            <input type="text" id="searchInput" placeholder="Tìm TLD hoặc giá...">
        </div>

        <div class="modern-table scrollable" style="--rowNumber: <?= $data->row_height ?? 1 ?>">
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
                    <?php foreach ($data->list as $value) { ?>
                        <tr class="<?= $value->domain_type ?>">
                            <td><?= $value->tld ?? '—' ?></td>
                            <td title="Giá đã bao gồm VAT – Thời hạn 1 năm" data-price="<?= $value->price_raw ?>">
                                <?= $value->price ?? '—' ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    #tino-iframe .modern-table-wrapper {
        font-family: "Roboto", sans-serif;
        padding-right: 13px !important;
    }

    #tino-iframe .table-controls {
        margin: 10px 0;
        text-align: right;
    }

    #tino-iframe #searchInput {
        width: 100% !important;
        padding: 8px 12px;
        font-size: 14px;
        width: 220px;
        border: 1px solid #ccc;
        border-radius: 4px;
        text-align: center;
    }

    #tino-iframe .modern-table {
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.05);
        height: calc(42px * var(--rowNumber));
    }

    #tino-iframe .modern-table table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }

    #tino-iframe .modern-table thead th {
        position: sticky;
        top: 0;
        background-color: #2e7d32;
        color: white;
        padding: 12px;
        font-size: 16px;
        z-index: 1;
        width: 50%;
    }

    #tino-iframe .modern-table tbody td {
        padding: 10px;
        border-bottom: 1px solid #e0e0e0;
        transition: background-color 0.2s ease, transform 0s ease;
        width: 50%;
    }

    #tino-iframe .modern-table tbody tr:hover td {
        background-color: white;
        transform: scale(1.4);
    }

    #tino-iframe .modern-table tr.cheap td {
        background-color: #e8f5e9;
    }

    #tino-iframe .modern-table tr.medium td {
        background-color: #fffde7;
    }

    #tino-iframe .modern-table tr.expensive td {
        background-color: #fce4ec;
    }

    #tino-iframe .scrollable {
        overflow-y: scroll;
        max-height: calc(42px * var(--rowNumber));
    }

    #tino-iframe {
        margin: 0;
        border: 1px solid #2e7d32;
        padding: 10px;
        border-radius: 8px;
    }
</style>
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll("#domainTable tbody tr");

        rows.forEach((row) => {
            const tld = row.cells[0].textContent.toLowerCase();
            const price = row.cells[1].textContent.toLowerCase();
            row.style.display =
                tld.includes(keyword) || price.includes(keyword) ? "" : "none";
        });
    });

    let sortAsc = true;
    document.getElementById("priceHeader").addEventListener("click", function() {
        const table = document.getElementById("domainTable").tBodies[0];
        const rows = Array.from(table.rows);

        rows.sort((a, b) => {
            const priceA = parseFloat(a.cells[1].dataset.price);
            const priceB = parseFloat(b.cells[1].dataset.price);
            return sortAsc ? priceA - priceB : priceB - priceA;
        });

        rows.forEach((row) => table.appendChild(row));
        sortAsc = !sortAsc;
        document.getElementById("sortIcon").textContent = sortAsc ? "⬆" : "⬇";
    });
</script>