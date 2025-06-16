function domainInspect(event) {
  // Khối tạo hiệu ứng chờ
  event.preventDefault();
  Utility.make().toggleSpinner("#spinner");
  Utility.make().freeze("#ajaxHtmlReplacer");
  Utility.make().alert(
    "#alertBox",
    "success",
    "Đang kiểm tra tên miền ... cảm ơn vì đã kiên nhẫn"
  );

  // Khối nhặt seclector
  const ajaxHtmlReplacer = jQuery("#ajaxHtmlReplacer");
  const domainInput = jQuery(".domainInput");

  const domainValue = domainInput.length ? domainInput.val() : "";

  // Khối dữ liệu fetch cần gửi đi
  const fetchBody = new URLSearchParams({
    action: "ajaxDomainInspect",
    domain: domainValue,
  });

  // Khối gói cấu hình fetch
  const fetchPackage = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: fetchBody,
    credentials: "same-origin",
  };

  // Khối chạy fetch
  fetch(scriptReceiver.adminAjaxUrl, fetchPackage)
    .then((response) => {
      if (!response.ok) {
        return response.text().then((text) => {
          throw new Error(`HTTP ${response.status}: ${text}`);
        });
      }
      return response.json();
    })
    .then((res) => {
      console.log("API response:", res);
      console.log("API response:", res.html);
      ajaxHtmlReplacer.html(res.html);
      return res;
    })
    .then((res) => {
      const redirectInspectStore = jQuery(".redirectInspectStore");
      if (redirectInspectStore.length) {
        if (res.json.info.code == 100) {
          redirectInspectStore.val(100).trigger("input");
        } else {
          redirectInspectStore.val(res.json.invoice_id).trigger("input");
        }
      } else {
        console.warn("Không tìm thấy redirectInspectStore sau khi render");
      }

      const domainInput = jQuery(".domainInput");
      if (domainInput.length) {
        domainInput.val(res.json.domain_name).trigger("input");

        Utility.make().alert(
          "#alertBox",
          res.json.info.color,
          res.json.info.alert
        );
      } else {
        console.warn("Không tìm thấy .domainInput sau khi render");
      }

      // Tạo nút domainToOrder (clone từ nút domainInspect rồi đổi class để có thể binder)
      const cloned = jQuery(".domainInspect").first().clone(); // clone
      cloned.removeClass("domainInspect").addClass("redirectInspect"); // đổi class
      if (res.json.info.code == 100) {
        cloned.text("Tiến hành đặt hàng").css("background-color", "#28a745"); // đổi class
        jQuery(".domainInspect").first().after(cloned); // chèn sau
      } else if (res.json.info.code == 200) {
        cloned.text("Hoá đơn đang chờ").css("background-color", "#ffc107"); // đổi class
        jQuery(".domainInspect").first().after(cloned); // chèn sau
      }
    })
    .catch((err) => {
      console.error("Lỗi fetch (đây là catch):", err);
      alert("Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau.");
    })
    .finally(() => {
      Utility.make().toggleSpinner("#spinner", "off");
      Utility.make().unfreeze("#ajaxHtmlReplacer");
    });
}

function redirectInspect(event) {
  // Khối tạo hiệu ứng chờ
  event.preventDefault();
  Utility.make().toggleSpinner("#spinner");
  Utility.make().freeze("#ajaxHtmlReplacer");
  Utility.make().alert(
    "#alertBox",
    "success",
    "Đang lấy hoá đơn ... cảm ơn vì đã kiên nhẫn"
  );

  // Khối nhặt seclector
  const invoiceSave = jQuery(".redirectInspectStore");
  console.log("orderFormUrl =", scriptReceiver.orderFormUrl);
  console.log("invoicePrintUrl =", scriptReceiver.invoicePrintUrl);
  if (invoiceSave.val() != 100) {
    const url =
      scriptReceiver.invoicePrintUrl + `?invoice=${invoiceSave.val()}`;
    window.open(url, "_blank"); // mở tab mới
    Utility.make().alert("#alertBox", "warning", "Đang đợi thanh toán...");
    Utility.make().toggleSpinner("#spinner", "off");
    Utility.make().unfreeze("#ajaxHtmlReplacer");
    return;
  } else {
    const url = scriptReceiver.orderFormUrl;
    window.open(url, "_blank"); // mở tab mới
    Utility.make().alert(
      "#alertBox",
      "success",
      "Đang đợi cung cấp thông tin đặt hàng..."
    );
    Utility.make().toggleSpinner("#spinner", "off");
    Utility.make().unfreeze("#ajaxHtmlReplacer");
    return;
  }
}

function contactCreateNew(event) {
  // Khối tạo hiệu ứng chờ
  event.preventDefault();
  Utility.make().toggleSpinner("#spinner");
  Utility.make().freeze("#ajaxHtmlReplacer");
  Utility.make().alert(
    "#alertBox",
    "success",
    "Đang kiểm tra tên miền ... cảm ơn vì đã kiên nhẫn"
  );

  const contactInfoPackage = {};

  jQuery(".formInput").each(function () {
    contactInfoPackage[jQuery(this).attr("id")] = jQuery(this).val();
  });

  // Khối dữ liệu fetch cần gửi đi
  const fetchBody = new URLSearchParams({
    action: "ajaxContactCreate",
    contactInfoPackage: JSON.stringify(contactInfoPackage),
  });

  // Khối gói cấu hình fetch
  const fetchPackage = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: fetchBody,
    credentials: "same-origin",
  };

  // Khối chạy fetch
  fetch(scriptReceiver.adminAjaxUrl, fetchPackage)
    .then((response) => {
      return Utility.make().responseStatus(response);
    })
    .then((res) => {
      console.log("API response:", res);

      if (Array.isArray(res.json) && res.json.length > 0) {
        const firstItem = res.json[0];

        if (
          typeof firstItem === "object" &&
          firstItem !== null &&
          firstItem.contact_id
        ) {
          // Xoá toàn bộ thông báo lỗi và class trạng thái cũ
          jQuery(".input-error").remove();
          jQuery(".formInput")
            .removeClass("input-success input-has-error")
            .siblings(".input-ok-icon")
            .remove();
          let confirmFormNameservers = [];

          jQuery("[id^='customerNameserver']").each(function () {
            let val = jQuery(this).val().trim();
            if (val) {
              confirmFormNameservers.push(val);
            }
          });
          let confirmFormDomainName = jQuery("#confirmFormDomainName")
            .text()
            .trim();
          $confirm = confirm(
            "Bạn có chắc muốn đặt hàng tên miền: " +
              confirmFormDomainName +
              " ?"
          );
          if ($confirm) {
            // contact_id có giá trị hợp lệ => tiến hành ajax đặt hàng
            console.log(
              firstItem.contact_id,
              confirmFormDomainName,
              confirmFormNameservers
            );
            domainToOrder(
              event,
              confirmFormDomainName,
              firstItem.contact_id,
              confirmFormNameservers
            );
          }
        } else {
          // Xoá toàn bộ thông báo lỗi và class trạng thái cũ
          jQuery(".input-error").remove();
          jQuery(".formInput")
            .removeClass("input-success input-has-error")
            .siblings(".input-ok-icon")
            .remove();

          const errorKeys = res.json;

          const errorMap = {
            useralreadyexistsemail_required: {
              id: "#customerEmail",
              msg: "Email này đã được sử dụng để đăng ký người dùng",
            },
            emailformat_required: {
              id: "#customerEmail",
              msg: "Email phải có định dạng: email@email.com",
            },
            firstname: {
              id: "#customerFirstname",
              msg: "Họ và tên lót không được để trống hoặc có kí tự lạ",
            },
            lastname: {
              id: "#customerLastname",
              msg: "Tên không được để trống hoặc có kí tự lạ",
            },
            so_cccd_passport_required: {
              id: "#customerNationalId",
              msg: "Căn cước/CMND cần có định dạng 8 đến 12 chữ số",
            },
            ngay_sinh_required: {
              id: "#customerBirthday",
              msg: "Ngày sinh không được để trống",
            },
            phonenumber: {
              id: "#customerPhone",
              msg: "Vui lòng nhập đúng định dạng số điện thoại",
            },
            state: {
              id: "#customerState",
              msg: "Tỉnh/ thành phố không được để trống",
            },
            city: {
              id: "#customerDistrict",
              msg: "Quận/huyện không được để trống",
            },
            phuong_xa_required: {
              id: "#customerWard",
              msg: "Phường/xã không được để trống",
            },
            address: {
              id: "#customerAddress",
              msg: "Địa chỉ chi tiết cần nhập",
            },
          };

          const allInputIds = [
            ...new Set(Object.values(errorMap).map((e) => e.id)),
          ];

          allInputIds.forEach((selector) => {
            const errorKey = Object.keys(errorMap).find(
              (k) => errorMap[k].id === selector && errorKeys.includes(k)
            );
            const $input = jQuery(selector);

            if (!$input.length) return;

            if (errorKey) {
              // Lỗi
              $input
                .addClass("input-has-error")
                .css("background-color", "white");
              jQuery(
                `<div class="alertBox input-error" style="color:#dc3545;font-size:0.85em;">`
              )
                .text(errorMap[errorKey].msg)
                .insertAfter($input);
            } else {
              $input.addClass("input-success").css("background-color", "white");
              const okIcon = jQuery(`<span class="input-ok-icon">OK ✓</span>`);
              $input.after(okIcon);
            }
          });

          // Cuộn tới input lỗi đầu tiên nếu có
          const $firstErrorInput = jQuery(".input-has-error").first();
          if ($firstErrorInput.length) {
            const offsetTop = $firstErrorInput.offset().top - 60; // trừ để khỏi che khuất
            jQuery("html, body").animate({ scrollTop: offsetTop }, 1200); // mượt mà
          }
        }
      }
      return res.json;
    })
    .catch((err) => {
      console.error("Lỗi fetch (đây là catch):", err);
      alert("Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau.");
    })
    .finally(() => {
      Utility.make().toggleSpinner("#spinner", "off");
      Utility.make().unfreeze("#ajaxHtmlReplacer");
    });
}

function domainToOrder(event, domain_name, contact_id, nameservers) {
  // Khối tạo hiệu ứng chờ
  event.preventDefault();
  Utility.make().toggleSpinner("#spinner");
  Utility.make().freeze("#ajaxHtmlReplacer");
  Utility.make().alert(
    "#alertBox",
    "success",
    "Đang lấy hoá đơn ... cảm ơn vì đã kiên nhẫn"
  );
  // Khối nhặt seclector
  // const ajaxHtmlReplacer = jQuery("#ajaxHtmlReplacer");
  // const domainInput = jQuery(".domainInput");
  // const domainValue = domainInput.length ? domainInput.val() : "";
  // const invoiceSave = jQuery(".invoiceSave");
  // Khối dữ liệu fetch cần gửi đi
  const fetchBody = new URLSearchParams({
    action: "ajaxDomainToOrder",
    domain: domain_name,
    contact_id: contact_id,
    nameservers: JSON.stringify(nameservers),
  });

  // Khối gói cấu hình fetch
  const fetchPackage = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: fetchBody,
    credentials: "same-origin",
  };
  console.log(JSON.stringify(nameservers));
  console.log(domain_name);
  console.log(contact_id);

  // Khối chạy fetch
  fetch(scriptReceiver.adminAjaxUrl, fetchPackage)
    .then((response) => {
      if (!response.ok) {
        return response.text().then((text) => {
          throw new Error(`HTTP ${response.status}: ${text}`);
        });
      }
      return response.json();
    })
    .then((res) => {
      console.log("API response:", res);
      if (res.json.invoice_id) {
        const url =
          scriptReceiver.invoicePrintUrl + `?invoice=${res.json.invoice_id}`;
        window.open(url, "_self");
      }
    })
    .catch((err) => {
      console.error("Lỗi fetch (đây là catch):", err);
      alert("Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau.");
    });
  // .finally(() => {
  //   // Utility.make().toggleSpinner("#spinner", "off");
  //   // Utility.make().unfreeze("#ajaxHtmlReplacer");
  // });
}

function invoiceStatusInspect() {
  const invoiceCheckerId =
    jQuery(".invoiceCheckerId").data("invoice-checker-id");
  console.log("Invoice ID:", invoiceCheckerId);

  if (invoiceCheckerId) {
    const fetchBody = new URLSearchParams({
      action: "ajaxInvoiceChecker",
      invoice_checker_id: invoiceCheckerId,
    });
    const fetchPackage = {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: fetchBody,
      credentials: "same-origin",
    };

    fetchInvoicInspect = function () {
      console.log("Ping...");
      fetch(scriptReceiver.adminAjaxUrl, fetchPackage)
        .then((response) => {
          if (!response.ok) {
            return response.text().then((text) => {
              throw new Error(`HTTP ${response.status}: ${text}`);
            });
          }
          return response.json();
        })
        .then((res) => {
          console.log("Phản hồi:", res.json);

          // Kiểm tra nếu đã thanh toán
          if (res.json.status === "Paid") {
            alert("Thông báo: Hoá đơn đã thanh toán thành công!");
            clearInterval(intervalId); // ❌ DỪNG LẶP NGAY
            clearTimeout(timeoutId);
            console.log("Dừng thao tác reload 5 phút chưa thanh toán");
            // Mở trang khác nếu cần
            // window.open("", "_self");
          } else {
            console.log("Thông báo: Đang đợi thanh toán...");
          }
        })
        .catch((err) => {
          console.error("Lỗi fetch (đây là catch):", err);
        });
    };

    fetchInvoicInspect();
    // Chạy invoice checker
    const intervalId = setInterval(() => {
      fetchInvoicInspect();
    }, 10000); // 10s check

    // Dừng sau 5 phút (30 lần tránh spam quá lâu)
    const timeoutId = setTimeout(() => {
      clearInterval(intervalId);
      alert(
        "Sau 5 phút hoá đơn chưa thanh toán, tự động reload trang (nếu đã thanh toán vẫn được xác nhận)"
      );
      location.reload();
    }, 300000);
  }
}
