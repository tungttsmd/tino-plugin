<div id="drawHere">
    <form id="orderForm" method="POST" style="max-width: 100%; margin: 20px 0;">
        <div style="margin-top: 10px; display: flex; gap: 20px">
            <input style="background:ghostwhite; width: 100%; flex: 7; padding-left: 10px" disabled placeholder="<?= $widget->data->domain ?? '' ?>">
            <!--- Warning start: Chưa nâng cấp bảo mật @csrf -->
            <input id="domainInput" type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            $.ajax({
                url: DOMAINORDEROBJECTAJAX.ajaxurl,
                data: {
                    action: "DOMAINORDER",
                    ajaxConfirm: "true",
                    domain: $("#domainInput").val(),
                    button: "orderConfirm",
                },
                method: "POST",
                success: function(res) {
                    const currentUrl = window.location.origin + window.location.pathname;
                    const config_invoiceUrl = res.hoadonUrl;
                    var newUrl = currentUrl + "?invoice=" + res.invoiceID;
                    if (config_invoiceUrl) {
                        newUrl = config_invoiceUrl + "?invoice=" + res.invoiceID;
                    }
                    const noload = $("#noload").val("load");
                    const form = document.getElementById("orderForm");

                    console.log(newUrl);
                    console.log(res.invoiceID);
                    console.log(res);
                    console.log("hello");

                    form.action = newUrl;
                    form.target = "_blank"; // Mở trong tab mới
                    form.submit();

                    form.action = currentUrl;
                    form.target = "_self"; // reload
                    form.submit();
                },
                error: function(res, b, c) {
                    console.log(res, b, c);
                }
            });
        } else {
            return false;
        }
    }
</script>