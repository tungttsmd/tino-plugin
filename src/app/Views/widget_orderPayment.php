<div id="drawHere">
  <form id="orderForm" method="POST" style="max-width: 100%; margin: 20px 0;">
    <div class="form-wrapper">
      <input
        type="text"
        class="domain-display"
        disabled
        placeholder="<?= $widget->data->domain ?? '' ?>"
      />
      <input id="domainInput" type="hidden" name="domain" value="<?= $widget->data->domain ?? '' ?>" />

      <button type="submit" name="button" value="orderOther" class="form-btn">Nhập tên miền khác</button>

      <button
        type="submit"
        name="button"
        value="orderPayment"
        onclick="domainInspect(event, '<?= $widget->data->domain ?? '' ?>')"
        class="form-btn primary"
      >Xem hoá đơn</button>

      <input type="hidden" name="button" id="buttonPOSTsend" value="">
      <input type="hidden" name="noload" id="noload" value="">
    </div>
  </form>
</div>
<style>
  .form-wrapper {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    align-items: center;
    margin-top: 10px;
    outline: 2px solid #2E7D32;
    padding: 10px;
    border-radius: 8px;
  }

  .domain-display {
    flex: 2 1 300px;
    padding: 10px;
    background: ghostwhite;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
  }

  .form-btn {
    flex: 1 1 160px;
    padding: 10px 14px;
    background: #f5f5f5;
    border: 1px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s, box-shadow 0.2s;
    font-weight: 500;
  }

  .form-btn:hover {
    background: #e0e0e0;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  }

  .form-btn.primary {
    background: #2e7d32;
    color: white;
    border-color: #2e7d32;
  }

  .form-btn.primary:hover {
    background: #1b5e20;
  }

  @media (max-width: 600px) {
    .form-wrapper {
      flex-direction: column;
      align-items: stretch;
    }

    .domain-display, .form-btn {
      width: 100%;
    }
  }
</style>
<script>
  function waitMe() {
    const el = document.getElementById('alertMe');
    if (el) el.innerText = '⏳ Quá trình này có thể mất một lát ... cảm ơn vì đã kiên nhẫn.';
  }
</script>
