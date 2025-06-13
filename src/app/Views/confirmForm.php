<div id="tino-container">
    <div id="spinnerDivCenter">
        <div id="spinner"></div>
    </div>

    <!-- start: ajax html replacer -->
    <div id="ajaxHtmlReplacer">
        <div class="uiBlock" style=" flex-direction: column; gap: 10px; width: 100%">
            <h2>Đặt mua tên miền</h2>

            <label> Tóm tắt thông tin đơn hàng</label>
            <table class="domain-summary-table">
                <thead>
                    <tr>
                        <th>Tên miền</th>
                        <th>Hạn dùng</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong><?= $data->domain_name ?? 'Tên miền không hợp lệ' ?></strong></td>
                        <td><strong><?= $data->domain_total ?? '0' ?> đ</strong></td>
                        <td><strong>01 năm</strong></td>
                    </tr>
                </tbody>
            </table>

            <label><strong>Thông tin chủ sở hữu tên miền</strong></label>

            <label>Họ và tên *</label>
            <input type="text" class="formInput" id="customerFirstname" placeholder="Nguyễn Văn A" required />
            <small><i>Vui lòng nhập đúng tên theo tên trên căn cước</i></small>

            <label>Ngày sinh *</label>
            <input type="text" class="formInput" id="customerBirthday" placeholder="dd/mm/yyyy" />
            <small><i>Vui lòng nhập đúng ngày sinh theo căn cước</i></small>

            <label>Giới tính *</label>
            <select class="formInput" id="customerGender">
                <option value="Male">Nam</option>
                <option value="Female">Nữ</option>
            </select>

            <label>Số CCCD/CMND *</label>
            <input type="text" class="formInput" id="customerNationalId" placeholder="046200005281" pattern="^\d{8,12}$" />

            <label>Số điện thoại *</label>
            <input type="tel" class="formInput" id="customerPhone" placeholder="0123 456 789" required />
            <small><i>Chúng tôi sẽ gửi thông tin đơn hàng theo Zalo số này</i></small>

            <label>Email *</label>
            <input type="email" class="formInput" id="customerEmail" placeholder="example@gmail.com" />

            <label>Tỉnh/Thành phố *</label>
            <input type="text" class="formInput" id="customerState" placeholder="Đà Nẵng" required />

            <label>Quận/Huyện *</label>
            <input type="text" class="formInput" id="customerDistrict" placeholder="Ngũ Hành Sơn" required />

            <label>Phường/Xã *</label>
            <input type="text" class="formInput" id="customerWard" placeholder="Hoà Hải" required />

            <label>Địa chỉ chi tiết *</label>
            <input type="text" class="formInput" id="customerAddress" placeholder="14 Mỹ An" required />

            <label>Quốc gia *</label>
            <input type="text" class="formInput" id="customerCountry" placeholder="Việt Nam" value="Việt Nam" required />

            <label>Email nhận hoá đơn *</label>
            <input type="email" class="formInput" id="customerEmailVat" placeholder="example@company.com" value="thanhtung.tran2k@gmail.com" />
            <small><i>Chúng tôi sẽ gửi hoá đơn qua email này</i></small>

            <label style="margin-top: 12px;"><strong>Upload căn cước công dân</strong></label>
            <div class="cccd-upload">
                <label>Ảnh mặt trước</label>
                <input type="file" accept="image/*" class="formInput" id="customerCccdFrontFile" />

                <label>Ảnh mặt sau</label>
                <input type="file" accept="image/*" class="formInput" id="customerCccdBackFile" />
            </div>

            <label>Cấu hình nameservers (tuỳ chọn)</label>
            <input type="text" class="formInput" id="customerNameserver1" placeholder="nameserver 1" />
            <input type="text" class="formInput" id="customerNameserver2" placeholder="nameserver 2" />
            <input type="text" class="formInput" id="customerNameserver3" placeholder="nameserver 3" />
            <input type="text" class="formInput" id="customerNameserver4" placeholder="nameserver 4" />

            <div class="button-wrapper" style="margin-top: 16px;">
                <button class="button-pretty contactCreateNew">Tiến hành mua</button>
                <button class="button-quit" id="cancelButton">Huỷ</button>
            </div>

        </div>
    </div>
    <!-- end: ajax html replacer -->

</div>
<style>
    /* Tối ưu form nhập thông tin */
    #tino-container .uiBlock {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        background: white;
        padding: 24px;
        border: 1px solid lavenderblush;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        max-width: 100%;
        margin: auto;
    }

    #tino-container .uiBlock h2 {
        font-size: 28px;
        margin-bottom: 10px;
        font-weight: 700;
        color: #333;
    }

    #tino-container .uiBlock label {
        font-weight: 600;
        margin-top: 10px;
        color: #333;
        font-size: 15px;
    }

    #tino-container .uiBlock input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
        background: #f9f9f9;
        transition: border-color 0.2s ease;
    }

    #tino-container .uiBlock input:focus {
        border-color: #5c1010;
        box-shadow: 0 0 2px black;
        outline: none;
        background: white;
    }

    /* Nút ở dưới cùng */
    #tino-container .button-wrapper {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-top: 20px;
    }

    /* Responsive nếu cần */
    @media (max-width: 500px) {
        #tino-container .button-wrapper {
            flex-direction: column;
            gap: 10px;
        }
    }

    .domain-summary-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-family: Arial, sans-serif;
        border: none;
    }

    .domain-summary-table th,
    .domain-summary-table td {
        padding: 12px 16px;
        border: 1px solid #ccc;
        text-align: left;
        border: none;
        text-align: center;
    }

    .domain-summary-table thead {
        background-color: #f8f8f8;
        font-weight: bold;
    }

    .domain-summary-table td strong {
        color: #333;
        font-size: 16px;
    }

    .domain-form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #2e7d32;
        border-radius: 10px;
        background-color: #fafafa;
        font-family: Arial, sans-serif;
    }

    .domain-form label {
        display: block;
        margin-top: 12px;
        font-weight: bold;
    }

    .formInput {
        width: 100%;
        padding: 10px;
        margin-top: 4px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    .cccd-upload {
        width: 100%;
        text-align: left;
    }

    .cccd-upload input[type="file"] {
        border: none;
        padding: 8px 0;
    }

    .formInput.input-success {
        background-color: #d4edda !important;
        padding-right: 2em;
        position: relative;
    }

    .input-ok-icon {
        color: #28a745;
        font-weight: bold;
        pointer-events: none;
    }

    .input-has-error {
        background-color: #f8d7da !important;
    }
</style>