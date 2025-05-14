function submitToSameTab(event) {
  const form = document.getElementById('orderForm');
  form.target = '_self'; // gửi trong tab hiện tại
  form.submit();
}

function confirmAndSubmitToNewTab(event, domainName) {
  event.preventDefault();
  const confirmMsg = 'Tên miền: ' + domainName + '. Xác nhận đặt hàng?';
  if (confirm(confirmMsg)) {
      $.ajax({
          url: DOMAINORDEROBJECTAJAX.ajaxurl,
          data: {
              action: "DOMAINORDER",
              ajaxConfirm: "true",
              domain: $("#domainInput").val(),
              button: "orderConfirm",
          },
          method: "POST",
          success: function(res) {
              const currentUrl = window.location.origin + window.location.pathname;
              const config_invoiceUrl = res.hoadonUrl;
              var newUrl = currentUrl + "?invoice=" + res.invoiceID;
              if (config_invoiceUrl) {
                  newUrl = config_invoiceUrl + "?invoice=" + res.invoiceID;
              }
              const noload = $("#noload").val("load");
              const form = document.getElementById("orderForm");

              console.log(newUrl);
              console.log(res.invoiceID);
              console.log(res);
              console.log("hello");

              form.action = newUrl;
              form.target = "_blank"; // Mở trong tab mới
              form.submit();

              form.action = currentUrl;
              form.target = "_self"; // reload
              form.submit();
          },
          error: function(res, b, c) {
              console.log(res, b, c);
          }
      });
  } else {
      return false;
  }
}