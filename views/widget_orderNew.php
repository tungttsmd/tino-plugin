<div id="spinnerOverlayBox">
    <div id="spinnerCenter">
        <div id="WaitSpinner"></div>
    </div>
    <div id="drawHere">
        <form method="POST" style="max-width: 100%; margin: 20px 0;">
            <div style="margin-top: 10px; display: flex; gap: 20px; margin-bottom: 20px;">
                <input type="text" id="domain" name="domain" placeholder="nhập tên miền bạn muốn mua: tenmien.vn" style="padding-left: 10px; padding-right: 10px; width: 100%; flex: 7" value="<?= $widget->data->domain ?? '' ?>">
                <button class="inspectOrderButton" type="submit" name="button" value="orderNew" style="flex: 3">Kiểm tra</button>
                <input id="domainInput" type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>">
                <input type="hidden" name="button" id="buttonPOSTsend" value="">
                <input type="hidden" name="noload" id="noload" value="">
            </div>
        </form>
        <div id="tinoPluginAlert" style="padding: 0px 20px; margin-bottom: 10px"></div>
    </div>
</div>