<div id="drawHere">
    <form id="orderForm" method="POST" style="max-width: 100%; margin: 20px 0;">
        <div style="margin-top: 10px; display: flex; gap: 20px">
            <input style="background:ghostwhite; width: 100%; flex: 7; padding-left: 10px" disabled placeholder="<?= $widget->data->domain ?? '' ?>">
            <!--- Warning start: Chưa nâng cấp bảo mật @csrf -->
            <input type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>">
            <!--- Warning end: Chưa nâng cấp bảo mật @csrf -->
            <button type="submit" name="button" onclick="submitToSameTab(event)" value="orderOther" style="flex: 3">Nhập tên miền khác</button>
            <button
                type="submit"
                name="button"
                value="orderConfirm"
                onclick="confirmAndSubmitToNewTab(event, '<?= $widget->data->domain ?? '' ?>')""
                style=" flex: 3">
                Tiến hành đặt hàng
            </button>
            <input type="hidden" name="button" id="buttonPOSTsend" value="">
            <input type="hidden" name="noload" id="noload" value="">
            <!-- <button type="button" id="ajaxButton" value="orderNew" style="flex: 3">Ajax run</button> -->
        </div>
    </form>
</div>
<script>
    function submitToSameTab(event) {
        const form = document.getElementById('orderForm');
        form.target = '_self'; // gửi trong tab hiện tại
        form.submit();
    }

    function confirmAndSubmitToNewTab(event, domainName) {
        event.preventDefault();
        const confirmMsg = 'Tên miền: ' + domainName + '. Xác nhận đặt hàng?';
        if (confirm(confirmMsg)) {
            document.getElementById('buttonPOSTsend').value = 'orderConfirm'; // Set giá trị
            const form = document.getElementById('orderForm');
            form.target = '_blank'; // gửi sang tab mới
            form.submit();
            document.getElementById('buttonPOSTsend').value = 'orderOther'; // Set giá trị
            document.getElementById('noload').value = 'load'; // Set giá trị
            form.target = '_self'; // gửi trong tab hiện tại
            form.submit();
        } else {
            return false;
        }
    }
</script>