<div id="drawHere">
    <form id="orderForm" method="POST" style="max-width: 100%; margin: 20px 0;">
        <div style="margin-top: 10px; display: flex; gap: 20px">
            <input style="background:ghostwhite; width: 100%; flex: 7; padding-left: 10px" disabled placeholder="<?= $widget->data->domain ?? '' ?>">
            <input id="domainInput" type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>">
            <button type="submit" name="button" value="orderOther" style="flex: 3">Nhập tên miền khác</button>
            <button type="submit" name="button" onclick="ajaxpost(event)" value="orderPayment" style="flex: 3">Xem hoá đơn</button>
            <input type="hidden" name="button" id="buttonPOSTsend" value="">
            <input type="hidden" name="noload" id="noload" value="">
            <!-- <button type="button" id="ajaxButton" value="orderNew" style="flex: 3">Ajax run</button> -->
    </form>
</div>


<script>
    function waitMe() {
        document.getElementById('alertMe').innerHTML = 'Quá trình này có thể mất một lát ... cảm ơn vì đã kiên nhẫn';
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>