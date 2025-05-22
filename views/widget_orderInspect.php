        <form method="POST" style="max-width: 100%; margin: 20px 0;">
            <div style="margin-top: 10px; display: flex; gap: 20px; margin-bottom: 20px;">
                <div class="uiBlock">
                    <input type="text" id="domain" name="domain" placeholder="nhập tên miền bạn muốn mua: tenmien.vn" style="padding-left: 10px; padding-right: 10px; width: 100%; flex: 7" value="<?= $widget->data->domain ?? '' ?>">
                    <button class="inspectOrderButton" type="submit" name="button" value="orderNew" style="flex: 3">Kiểm tra</button>
                </div>
                <input id="domainInput" type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>">

                <input type="hidden" name="button" id="buttonPOSTsend" value="">
                <input type="hidden" name="noload" id="noload" value="">
            </div>
        </form>