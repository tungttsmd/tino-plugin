// Bind button
jQuery(document).on("click", ".domainInspect", function (event) {
  domainInspect.call(this, event);
});
jQuery(document).on("click", ".redirectInspect", function (event) {
  redirectInspect.call(this, event);
});
jQuery(document).on("click", ".contactCreateNew", function (event) {
  contactCreateNew.call(this, event);
});

// Gắn hàm chạy kiểm tra hoá đơn
jQuery(document).ready(function () {
  // Nếu tồn tại phần tử có class .invoiceCheckerId trong DOM thì gọi hàm
  if (jQuery("#tino-container .invoiceCheckerId").length > 0) {
    invoiceStatusInspect();
  }
});

// Nút đóng alert
jQuery(document).on("click", ".alertClose", function () {
  const $alert = jQuery(this).closest(".alert");

  if ($alert.hasClass("fade")) {
    $alert.removeClass("show");

    const removeAlert = () => {
      $alert.remove();
    };

    $alert.one("transitionend", removeAlert);

    setTimeout(function () {
      if (document.body.contains($alert[0])) {
        removeAlert();
      }
    }, 500);
  } else {
    $alert.remove();
  }
});

// Xoá nút Đặt hàng và Hoá đơn khi thay đổi domain
jQuery("#tino-container").on("input", ".domainInput", function () {
  const $redirect = jQuery(".redirectInspect");
  if ($redirect.length) {
    $redirect.fadeOut(300, function () {
      jQuery(this).remove();
      console.log("Đã xoá redirectInspect vì domain thay đổi");
    });
  }
});

// Xoá khi click vào chính nó
jQuery(document).on("click", ".redirectInspect", function () {
  const $this = jQuery(this);
  $this.fadeOut(300, function () {
    $this.remove();
    console.log("Đã xoá redirectInspect khi click vào chính nó");
  });
});

// Khi người dùng focus hoặc nhập input, nền trắng luôn
jQuery(".formInput").on("input", function () {
  this.style.setProperty("background-color", "white", "important");
});
