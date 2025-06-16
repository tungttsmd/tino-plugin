<?php
$data->location = new stdClass;
$data->location->district_list = ["Đà Nẵng", "Hồ Chí Minh", "Hà Nội"];
$data->location->countries_list = ["Việt Nam"];
$data->location->ward_list = ["Phú Thượng", "Hoà Hải", "Mỹ An"];
$data->location->state_list = ["Sơn Trà", "Thuận Hoá", "Ngũ Hành Sơn"];
?>

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

            <div style="display: flex; gap: 20px">
                <div>
                    <label style="display: flex; text-align: right; justify-content: start;">Họ và tên lót *</label>
                    <input type="text" class="formInput" id="customerFirstname" placeholder="Trần Đỗ Văn..." required />
                    <small><i>Vui lòng nhập đúng theo CCCD, vd: Trần Đỗ Văn Anh nhập "Trần Đỗ Văn"</i></small>
                </div>
                <div>
                    <label style="display: flex; text-align: right; justify-content: start;">Tên *</label>
                    <input type="text" class="formInput" id="customerLastname" placeholder="Anh..." required />
                    <small><i>Vui lòng nhập đúng theo CCCD, vd: Trần Đỗ Văn Anh nhập "Anh"</i></small>
                </div>
            </div>

            <label>Ngày sinh *</label>
            <input
                type="date"
                class="formInput"
                id="customerBirthday"
                required />

            <label>Giới tính *</label>
            <div style="display: flex; gap: 20px">
                <label><input type="radio" class="formInput" name="customerGender" value="male" required checked/></label> <label>Nam</label></span>
                <label><input type="radio" class="formInput" name="customerGender" value="female" required /> </label><label>Nữ</label></span>
            </div>

            <label>Số CCCD *</label>
            <input
                type="text"
                class="formInput"
                id="customerNationalId"
                required
                minlength="8"
                maxlength="12"
                pattern="\d{8,12}"
                title="CCCD/CMND chỉ bao gồm từ 8 đến 12 chữ số" />

            <label>Số điện thoại *</label>
            <input
                type="text"
                class="formInput"
                id="customerPhone"
                placeholder="+849..."
                required
                pattern="^\+?\d{8,15}$"
                title="Số điện thoại hợp lệ bao gồm dấu + và số" />
            <small><i>Chúng tôi sẽ gửi thông tin đơn hàng theo Zalo số này</i></small>

            <label>Email *</label>
            <input
                type="email"
                class="formInput"
                id="customerEmail"
                placeholder="email@example.com"
                required />

            <label>Quốc gia *</label>
            <select class="formInput" id="customerCountry" required>
                <?php foreach ($data->location->countries_list as $country): ?>
                    <option value="<?= $country ?>"><?= $country ?></option>
                <?php endforeach; ?>
            </select>

            <label>Tỉnh / Thành phố *</label>
            <select class="formInput" id="customerState" required>
                <?php foreach ($data->location->state_list as $state): ?>
                    <option value="<?= $state ?>"><?= $state ?></option>
                <?php endforeach; ?>
            </select>

            <label>Quận / Huyện *</label>
            <select class="formInput" id="customerDistrict" required>
                <?php foreach ($data->location->district_list as $district): ?>
                    <option value="<?= $district ?>"><?= $district ?></option>
                <?php endforeach; ?>
            </select>

            <label>Phường/Xã *</label>
            <select class="formInput" id="customerWard" required>
                <?php foreach ($data->location->ward_list as $ward): ?>
                    <option value="<?= $ward ?>"><?= $ward ?></option>
                <?php endforeach; ?>
            </select>

            <label>Địa chỉ chi tiết *</label>
            <input
                type="text"
                class="formInput"
                id="customerAddress"
                placeholder="Số nhà, tên đường..."
                required />

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