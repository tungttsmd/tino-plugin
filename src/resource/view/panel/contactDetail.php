<div class="formEdit" style="font-family: Arial, sans-serif; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
    <div class="button-wrapper" style="display: flex; width: 100%; margin-bottom: 20px">
        <h3 style="width: 100%"><b>👤 Thông tin liên hệ</b></h3>
        <button type="button" style=" width: 100%" class="button-outline" onclick="loadpage('contact',null,'#ajaxHtmlReplacer')">Quay lại danh sách liên hệ</button>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <th style="text-align: left; width: 200px;">Access ID</th>
            <td><input class="formEdit" type="text" name="contact[id]" value="<?= htmlspecialchars($data->id) ?>" style="width: 100%;" readonly />
                <small>Access Id dùng để xem thông tin liên hệ và lấy client ID</small>
            </td>
        </tr>
        <tr>
            <th style="text-align: left; width: 200px;">Client ID:</th>
            <td><input class="formEdit" type="text" name="contact[id]" value="<?= htmlspecialchars($data->client_id) ?>" style="width: 100%;" readonly />
                <small>Client ID dùng để đặt hàng kèm theo thông tin liên hệ</small>
            </td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><input class="formEdit" type="email" name="contact[email]" value="<?= htmlspecialchars($data->email) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Họ và tên:</th>
            <td><input class="formEdit" type="text" name="contact[firstname]" value="<?= htmlspecialchars($data->firstname) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Công ty:</th>
            <td><input class="formEdit" type="text" name="contact[companyname]" value="<?= htmlspecialchars($data->companyname) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Địa chỉ:</th>
            <td><input class="formEdit" type="text" name="contact[address1]" value="<?= htmlspecialchars($data->address1) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Thành phố:</th>
            <td><input class="formEdit" type="text" name="contact[city]" value="<?= htmlspecialchars($data->city) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Tỉnh/Bang:</th>
            <td><input class="formEdit" type="text" name="contact[state]" value="<?= htmlspecialchars($data->state) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Quốc gia:</th>
            <td><input class="formEdit" type="text" name="contact[country]" value="<?= htmlspecialchars($data->country) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Số điện thoại:</th>
            <td><input class="formEdit" type="text" name="contact[phonenumber]" value="<?= htmlspecialchars($data->phonenumber) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Ngôn ngữ:</th>
            <td><input class="formEdit" type="text" name="contact[language]" value="<?= htmlspecialchars($data->language) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Là công ty:</th>
            <td>
                <select name="contact[company]" class="formEdit" style="width: 100%;">
                    <option value="0" <?= !$data->company ? 'selected' : '' ?>>Không</option>
                    <option value="1" <?= $data->company ? 'selected' : '' ?>>Có</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>Phường/Xã:</th>
            <td><input class="formEdit" type="text" name="contact[ward]" value="<?= htmlspecialchars($data->ward) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Mã số thuế:</th>
            <td><input class="formEdit" type="text" name="contact[taxid]" value="<?= htmlspecialchars($data->taxid) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>CMND/CCCD:</th>
            <td><input class="formEdit" type="text" name="contact[nationalid]" value="<?= htmlspecialchars($data->nationalid) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Ngày sinh:</th>
            <td><input class="formEdit" type="text" name="contact[birthday]" value="<?= htmlspecialchars($data->birthday) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Giới tính:</th>
            <td><input class="formEdit" type="text" name="contact[gender]" value="<?= htmlspecialchars($data->gender) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Email VAT:</th>
            <td><input class="formEdit" type="email" name="contact[emailvat]" value="<?= htmlspecialchars($data->emailvat) ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th>Mật khẩu (hash):</th>
            <td><input class="formEdit" type="text" name="contact[password]" value="<?= htmlspecialchars($data->password) ?>" style="width: 100%;" /></td>
        </tr>
    </table>
</div>