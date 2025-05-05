<?php $widget = betterStd($_POST['widget']) ?? null ?>
<form method="POST" style="max-width: 100%; margin: 20px 0;">
    <div style="margin-top: 10px; display: flex; gap: 20px">
        <input style="background:ghostwhite; width: 100%; flex: 7; padding-left: 10px" disabled placeholder="<?= $widget->data->domain ?? '' ?>">
        <!--- Warning start: Chưa nâng cấp bảo mật @csrf -->
        <input type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>">
        <!--- Warning end: Chưa nâng cấp bảo mật @csrf -->
        <button type="submit" name="button" value="orderOther" style="flex: 3">Nhập tên miền khác</button>
        <button
            type="submit"
            name="button"
            value="orderConfirm"
            onclick="return confirm('Tên miền: <?= $widget->data->domain ?? '' ?>. Xác nhận đặt hàng?')"
            style="flex: 3">
            Tiến hành đặt hàng
        </button>
    </div>
</form>