<div id="spinnerOverlayBox">
    <div id="spinnerCenter">
        <div id="WaitSpinner"></div>
    </div>
    <div id="drawHere">
        <form id="orderForm" method="POST" style="max-width: 100%; margin: 20px 0;">
            <div style="margin-top: 10px; display: flex; gap: 20px">
                <input id="domain" style="background:ghostwhite; width: 100%; flex: 7; padding-left: 10px" value="<?= $widget->data->domain ?? '' ?>">
                <input id="domainInput" type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>">

                <button class="inspectOrderButton" type="submit" name="button" value="orderNew" style="flex: 3">Kiểm tra</button>
                <button id="invoiceRenderButtonId" type="submit" name="button" value="orderPayment" style="flex: 3">Xem hoá đơn</button>
                <input type="hidden" name="button" id="buttonPOSTsend" value="">
                <input type="hidden" name="noload" id="noload" value="">
            </div>
        </form>
    </div>
</div>