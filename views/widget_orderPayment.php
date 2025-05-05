<?php $widget = betterStd($_POST['widget']) ?? null ?>
<form method="POST" style="max-width: 100%; margin: 20px 0;">
    <div style="margin-top: 10px; display: flex; gap: 20px">
        <input style="background:ghostwhite; width: 100%; flex: 7; padding-left: 10px" disabled placeholder="<?= $widget->data->domain ?? '' ?>">
        <input type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>">
        <button type="submit" name="button" value="orderOther" style="flex: 3">Nhập tên miền khác</button>
        <button type="submit" name="button" onclick="waitMe()" value="orderPayment" style="flex: 3">Xem hoá đơn</button>
    </div>
</form>

<script>
    function waitMe() {
        document.getElementById('alertMe').innerHTML = 'Quá trình này có thể mất một lát ... cảm ơn vì đã kiên nhẫn';
    }
</script>