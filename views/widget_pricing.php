<?php
require(dirname(__DIR__).'/lib/lib.php');
require(dirname(__DIR__).'/app/Models/Config.php');
require(dirname(__DIR__).'/config.php');
require(dirname(__DIR__).'/app/System/Apiclient.php');
require(dirname(__DIR__).'/app/Models/Tld.php');
require(dirname(__DIR__).'/app/Models/Login.php');
$login = new Login($config_username, password: $config_password);
$tld = new Tld($login->getToken());
$list = new stdClass;
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
<div class="scrollable" style="font-family: Roboto, sans-serif; --rowNumber: <?= $config_rowTable ?? 1 ?>">
    <table cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: center;">
        <thead style="background-color: #2e7d32; color: white">
            <tr>
                <th>Tên miền</th>
                <th>Đăng ký mới</th>
                <th>Chuyển về Tino Group</th>
                <th>Gia hạn</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($list as $value) { ?>
                <tr>
                    <td><?= $value->tld ?? null ?></td>
                    <td><?= $value->register ?? null ?></td>
                    <td><?= $value->transfer ?? null ?></td>
                    <td><?= $value->renew ?? null ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<style>
    .scrollable {
        outline: 1px solid #2e7d32;
        height: calc(80px*var(--rowNumber));
        max-height: calc(80px*var(--rowNumber));
    }

    .scrollable td {
        height: 42px;
        min-height: 42px;
        border: 1px solid #2e7d32;
    }

    .scrollable thead th {
        position: sticky;
        top: -1;
        background-color: #2e7d32;
        color: white;
        z-index: 1;
    }

    .scrollable thead {
        border: 1px solid #2e7d32;
    }
</style>