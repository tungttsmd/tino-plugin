<?php if ($data->status === 'ok') { ?>
  <div class="domain-item">
    <div class="domain-left">
      <div class="domain-name"><?= $data->domain ?></div>
      <div class="status">Khả dụng</div>
    </div>
    <div class="domain-right">
      <div class="price" ">Bắt đầu từ: <?= $data->price ?> đ</div>
            <a class=" btn suggestionSelection"
        data-price="<?= $data->price ?>"
        data-domain-name="<?= $data->domain ?>">Chọn tên miền</a>
      </div>
    </div>
  <?php } else { ?>
    <div class="domain-item">
      <div class="domain-left">
        <div class="domain-name false"><?= $data->domain ?></div>
      </div>
      <div class="domain-right">
        <div class="status false">Không khả dụng</div>
      </div>
    </div>
  <?php } ?>