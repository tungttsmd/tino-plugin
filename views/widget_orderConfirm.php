<div id="drawHere">
    <form id="orderForm" method="POST" style="max-width: 100%; margin: 20px 0;">
        <div style="margin-top: 10px; display: flex; gap: 20px">
            <input id="domain" style="background:ghostwhite; width: 100%; flex: 7; padding-left: 10px" value="<?= $widget->data->domain ?? '' ?>">
            <!--- Warning start: Chưa nâng cấp bảo mật @csrf -->
            <input id="domainInput" type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>">
            <!--- Warning end: Chưa nâng cấp bảo mật @csrf -->
            <button type="submit" name="button" onclick="ajaxCheckForm(event)" value="orderNew" style="flex: 3">Kiểm tra</button>
            <button
                type="submit"
                id="orderNewButton"
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
