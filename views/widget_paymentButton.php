<?php $widget = betterStd($_POST['widget']) ?? null ?>
<style>
    .button-pretty {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        background: linear-gradient(to right, #4facfe, #00f2fe);
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .button-pretty:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.2);
    }

    .button-outline {
        padding: 10px 20px;
        border: 2px solid #00c9ff;
        border-radius: 8px;
        background: white;
        color: #00c9ff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .button-outline:hover {
        background: #00c9ff;
        color: white;
        transform: scale(1.05);
    }

    .button-reload {
        background-color: white;
        color: black;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .button-quit {
        padding: 10px 20px;
        border: 2px solid rgb(254, 79, 79);
        border-radius: 8px;
        background: linear-gradient(to right, rgb(254, 79, 79), rgb(254, 216, 0));
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .button-quit:hover {
        background: rgb(254, 79, 79);
        color: white;
        transform: scale(1.05);
    }

    .button-wrapper {
        display: flex;
        justify-content: space-between;
    }

    .button-wrapper a {
        flex: 1 1 1;
    }
</style>

<div class="button-wrapper" style="margin-top: -30px; gap: 20px">
    <a href="<?= $widget->button->VNPayHref ?>" target="_blank" rel="noopener noreferrer" style="width: 100%;">
        <button class="button-pretty" style="width: 100%;">Thanh toán qua VNPAY</button>
    </a>
    <a href="<?= $widget->button->MomoHref ?>" target="_blank" rel="noopener noreferrer" style="width: 100%;">
        <button class="button-outline" style="width: 100%;">Thanh toán qua MOMO</button>
    </a>
    <a style="width: 100%;">
        <button
            class="button-outline"
            type="button"
            onclick="if (confirm('Bạn chưa thanh toán, tên miền này sẽ không thể đặt lại. Bạn có muốn tạo mới không?')) { window.location.href = window.location.origin + window.location.pathname; }"
            style="width: 100%;">
            Mua tên miền khác
        </button>
    </a>

    <a style="width: 100%;">
        <button class="button-quit" type="button" onclick="window.location.href = 'https://webo.vn'" style="width: 100%;">Về trang chủ</button>
    </a>

</div>