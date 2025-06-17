<form method="POST">
    <div class="uiBlock">
        <!-- Input chính -->
        <input type="text" class="domainInput" placeholder="nhập tên miền bạn muốn mua: tenmien.vn" />
        <button type="button" class="domainInspect">Kiểm tra</button>
	<a href="<?=CONFIG_INVOICE_PRINT_URL??DOMAIN?>?tab=panel">
	    <button class="button-pretty" style="color: white; width: 100%">Trang quản lý dữ liệu</button>
	</a>
        <!-- Input ẩn để giữ domain name và invoice cũ nếu vô tình thay đổi -->
        <input type="text" class="redirectInspectStore" hidden>
    </div>
</form>
<div id="alertBox"></div>