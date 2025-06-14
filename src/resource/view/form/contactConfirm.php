<div id="tino-container">
    <div id="spinnerDivCenter">
        <div id="spinner"></div>
    </div>

    <!-- start: ajax html replacer -->
    <div id="ajaxHtmlReplacer">
        <div class="uiBlock contactForm" style=" flex-direction: column; gap: 10px; width: 100%">
            <h2>Đặt mua tên miền</h2>

            <label> Tóm tắt thông tin đơn hàng</label>
            <table class="domain-summary-table">
                <thead>
                    <tr>
                        <th>Tên miền</th>
                        <th>Tổng tiền</th>
                        <th>Hạn dùng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="confirmFormDomainName"><strong><?= $data->domain_name ?? null ?></strong></td>
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