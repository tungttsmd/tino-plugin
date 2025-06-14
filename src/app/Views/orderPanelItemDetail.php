<?php

/** @var stdClass $data */ ?>

<form method="post" class="formEdit" style="font-family: Arial, sans-serif; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
    <h2>🔍 Thông tin đơn hàng</h2>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <th style="text-align: left; width: 200px;">Mã đơn hàng:</th>
            <td><input class="formEdit" type="text" name="order_id" value="<?= htmlspecialchars($data->order_id ?? '...') ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th style="text-align: left;">Trạng thái thanh toán:</th>
            <td>
                <select name="payment" class="formEdit" style="width: 100%;">
                    <option value="Pending" <?= $data->payment === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Paid" <?= $data->payment === 'Paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="Failed" <?= $data->payment === 'Failed' ? 'selected' : '' ?>>Failed</option>
                </select>
            </td>
        </tr>
        <tr>
            <th style="text-align: left;">Ngày đặt:</th>
            <td><input class="formEdit" type="date" name="order_date" value="<?= htmlspecialchars($data->order_date ?? '...') ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th style="text-align: left;">Tên miền:</th>
            <td><input class="formEdit" type="text" name="domain_name" value="<?= htmlspecialchars($data->domain_name ?? '...') ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th style="text-align: left;">Giá tên miền:</th>
            <td><input class="formEdit" type="number" name="domain_price" value="<?= htmlspecialchars($data->domain_price ?? '...') ?>" style="width: 100%;" /></td>
        </tr>
    </table>

    <h3>🌐 Name Servers</h3>
    <div style="margin-bottom: 20px;">
        <?php foreach ($data->nameservers as $i => $ns): ?>
            <input class="formEdit" type="text" name="nameservers[]" value="<?= htmlspecialchars(string: $ns) ?>" style="display: block; margin-bottom: 5px; width: 100%;" />
        <?php endforeach; ?>
    </div>

    <h3>👤 Thông tin liên hệ</h3>
    <div style="display: flex; flex-direction: column; gap: 20px;">

        <?php
        $contacts = [
            'registrant' => 'Người đăng ký',
            'admin'      => 'Quản trị',
            'tech'       => 'Kỹ thuật',
            'billing'    => 'Thanh toán'
        ];
        ?>

        <?php foreach ($contacts as $key => $label): ?>

            <?php $c = $data->contact->$key; ?>
            exit; ?>
            <fieldset style="width: 100%; border: 1px solid #ddd; padding: 12px; border-radius: 6px;">
                <legend style="font-weight: bold;"><?= $label ?></legend>
                <label>Client ID<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][name]" value="<?= htmlspecialchars($c->contactid  ?? '...') ?>" style="width: 100%;" />
                </label><br>
                <label>Họ tên:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][name]" value="<?= htmlspecialchars($c->firstname ?? '...') ?>" style="width: 100%;" />
                </label><br>

                <label>Email:<br>
                    <input class="formEdit" type="email" name="contact[<?= $key ?>][email]" value="<?= htmlspecialchars($c->email ?? '...') ?>" style="width: 100%;" />
                </label><br>

                <label>SĐT:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][phonenumber]" value="<?= htmlspecialchars($c->phonenumber ?? '...') ?>" style="width: 100%;" />
                </label><br>

                <label>Quốc gia:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][country]" value="<?= htmlspecialchars($c->country ?? '...') ?>" style="width: 100%;" />
                </label><br>

                <label>Cơ quan:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][country]" value="<?= htmlspecialchars($c->companyname ?? '...bổ sung sau') ?>" style="width: 100%;" />
                </label><br>

                <!-- <label>Loại:<br>
                    <select name="contact[<?= $key ?>][type]" class="formEdit" style="width: 100%;">
                        <option value="ind" <?= isset($c->type) && $c->type === 'ind' ? 'selected' : '' ?>>Cá nhân</option>
                        <option value="org" <?= isset($c->type) && $c->type === 'org' ? 'selected' : '' ?>>Tổ chức</option>
                    </select>
                </label><br> -->

                <!-- <label>Ngày sinh:<br>
                    <input class="formEdit" type="date" name="contact[<?= $key ?>][birthday]" value="<?= htmlspecialchars($c->birthday ?? '...') ?>" style="width: 100%;" />
                </label><br> -->

                <!-- <label>CMND/CCCD:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][nationalid]" value="<?= htmlspecialchars($c->nationalid ?? '...') ?>" style="width: 100%;" />
                </label><br> -->

                <!-- <label>Giới tính:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][gender]" value="<?= htmlspecialchars($c->gender ?? '...') ?>" style="width: 100%;" />
                </label><br> -->

                <label>Địa chỉ chi tiết:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][address1]" value="<?= htmlspecialchars($c->address1 ?? '...') ?>" style="width: 100%;" />
                </label><br>

                <label>Phường/Xã:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][ward]" value="<?= htmlspecialchars($c->ward ?? '...') ?>" style="width: 100%;" />
                </label><br>

                <label>Thành phố:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][city]" value="<?= htmlspecialchars($c->city ?? '...') ?>" style="width: 100%;" />
                </label><br>

                <label>Tỉnh/Thành:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][state]" value="<?= htmlspecialchars($c->state ?? '...') ?>" style="width: 100%;" />
                </label><br>

                <!-- <label>Mã bưu chính:<br>
                    <input class="formEdit" type="text" name="contact[<?= $key ?>][postcode]" value="<?= htmlspecialchars($c->postcode ?? '...') ?>" style="width: 100%;" />
                </label> -->
            </fieldset>
        <?php endforeach; ?>
    </div>
    <div class="button-wrapper" style="margin-top: 20px;display: flex; gap: 20px;width: 100%">
        <button style="width: 100%" type="submit" class="formEdit" style="padding: 10px 20px; font-weight: bold;">💾 Lưu thay đổi</button>
        <a style="width: 100%" href="?tab=order">
            <button type="button" style=" width: 100%" class="button-outline">Quay lại danh sách đặt hàng</button>
        </a>
    </div>
</form>