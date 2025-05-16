<div id="drawHere">
    <div class="button-wrapper" style="margin-top: -30px; gap: 20px">
        <a href="<?= $widget->button->VNPayHref ?>" target="_blank" rel="noopener noreferrer" style="width: 100%;">
            <button class="button-pretty" style="width: 100%;">Thanh toán qua VNPAY</button>
        </a>
        <a href="<?= $widget->button->MomoHref ?>" target="_blank" rel="noopener noreferrer" style="width: 100%;">
            <button class="button-outline" style="width: 100%;">Thanh toán qua MOMO</button>
        </a>
        <a style="width: 100%;">
            <button class="button-quit" type="button" onclick="window.location.href = 'https://webo.vn'" style="width: 100%;">Về trang chủ</button>
        </a>
    </div>
</div>