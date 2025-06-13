<form method="POST" style="max-width: 100%; margin: 20px 0;">
    <div class="uiBlock" style="margin-top: 10px; display: flex; gap: 20px; margin-bottom: 20px;">
        <!-- Input chính -->
        <input type="text" class="domainInput" placeholder="nhập tên miền bạn muốn mua: tenmien.vn" style="padding-left: 10px; padding-right: 10px; width: 100%; flex: 7">
        <button type="button" class="domainInspect" style="flex: 3">Kiểm tra</button>
        <!-- Input ẩn để giữ domain name và invoice cũ nếu vô tình thay đổi trước khi bấm domainToOrder -->
        <input type="text" class="redirectInspectStore" hidden>
    </div>

</form>
<div id="alertBox" style="padding: 0px 20px; margin-bottom: 10px"></div>