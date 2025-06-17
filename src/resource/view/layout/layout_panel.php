<div id="tino-container" style="margin-top: 120px">
    <div id="spinnerDivCenter">
        <div id="spinner"></div>
    </div>

   <h3> TINO PLUGIN CPANEL (AUTHOR: TRAN THANH TUNG) </h3>
   <div style="max-width: 1140px; margin: auto">
       <div class="tab-buttons">
           <button onclick="loadpage('order', null,'#ajaxHtmlReplacer')" type="button">Danh sách đặt hàng</button>
           <button onclick="loadpage('contact', null, '#ajaxHtmlReplacer')" type="button">Danh sách liên hệ</button>
           <button onclick="loadpage('invoice', null,'#ajaxHtmlReplacer')" type="button">Danh sách hoá đơn</button>
           <!-- Ô tìm kiếm được gán ID để xử lý -->
           <input id="searchInput" type="text" placeholder="Tìm kiếm bất kì..." style="border-radius: 8px; flex: 1; padding: 8px;" />
       </div>


       <!-- <button class="button-pretty" onclick="alert('Tạo liên hệ mới')">+ Tạo mới</button> -->
       <span>Bấm vào tên cột để sắp xếp asc/desc</span>
       <div id="ajaxHtmlReplacer" class="panelTable" style="border: 1px solid lighgrey; border-radius: 8px;">
       </div>
   </div>
</div>
<style>
    .panelTable table {
        width: 100%;
        border-collapse: collapse;
        font-family: "Segoe UI", sans-serif;
        table-layout: fixed;
        margin-top: 20px;
        background-color: white;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-radius: 6px;
        overflow: hidden;
    }

    .panelTable thead {
        background-color: #f9fafb;
    }

    .panelTable th,
    .panelTable td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
        font-size: 14px;
        word-break: break-word;
    }

    .panelTable th {
        background: linear-gradient(to right, #f0f0f0, #fafafa);
        font-weight: 600;
        color: #333;
        cursor: pointer;
        position: relative;
        transition: background 0.2s ease, transform 0.15s ease;
        user-select: none;
    }

    .panelTable th:hover {
        background-color: #e6f0ff;
        transform: scale(1.05);
    }

    .panelTable th.asc::after {
        content: " ▲";
        position: absolute;
        right: 10px;
    }

    .panelTable th.desc::after {
        content: " ▼";
        position: absolute;
        right: 10px;
    }

    .panelTable tbody tr:nth-child(even) {
        background-color: #fafafa;
    }

    .panelTable tbody tr:hover {
        background-color: #eef5ff;
    }

    .panelTable .alert {
        display: inline-block;
        border-radius: 4px;
        font-size: 12px;
        padding: 4px 8px;
        color: white;
    }

    .panelTable .alert-success {
        background-color: #28a745;
    }

    .panelTable .alert-danger {
        background-color: #dc3545;
    }

    .panelTable .button-outline {
        padding: 6px 12px;
        border: 1px solid #007bff;
        background: white;
        color: #007bff;
        border-radius: 4px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .panelTable .button-outline:hover {
        background-color: #007bff;
        color: white;
    }
</style>