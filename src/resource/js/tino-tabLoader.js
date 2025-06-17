function loadpage(tab_data, detail_data, selector) {
  // Khối tạo hiệu ứng chờ
  Utility.make().toggleSpinner("#spinnerDivCenter");
  Utility.make().freeze("#ajaxHtmlReplacer");
  Utility.make().alert(
    "#alertBox",
    "warning",
    "Đang lấy dữ liệu..."
  );

  const contentDiv = jQuery(selector); // Lấy thẻ #content
  // Khối dữ liệu fetch cần gửi đi
  const fetchBody = new URLSearchParams({
    action: "ajaxTabLoader",
    tab: tab_data,
    detail: detail_data,
  });

  // Khối gói cấu hình fetch
  const fetchPackage = {
    method: "POST",
    body: fetchBody,
    credentials: "same-origin",
  };

  // Khối chạy fetch
  fetch(scriptReceiver.adminAjaxUrl, fetchPackage)
    .then((res) => {
      if (!res.ok) throw new Error("Lỗi tải nội dung");
      return res.json(); // Lấy response là HTML
    })
    .then((res) => {
      console.log("Phản hồi: " + res.html);
      contentDiv.html(res.html); // Gán HTML vào div content

      if (
        jQuery(".orderList").length > 0 ||
        jQuery(".contactList").length > 0 ||
        jQuery(".invoiceList").length > 0
      ) {
        // 🔁 Sau khi load HTML xong, kiểm tra class và gắn script phù hợp
        panelSearch();
      }
    })
    .catch((err) => {
      contentDiv.html(`<p style="color:red;">${err.message}</p>`); // Nếu lỗi thì báo
    })
    .finally(() => {
      Utility.make().toggleSpinner("#spinnerDivCenter", "off");
      Utility.make().unfreeze("#ajaxHtmlReplacer");
    });

  // Xử lý nút active
  const buttons = document.querySelectorAll(".tab-buttons button");
  buttons.forEach((btn) => btn.classList.remove("active"));

  // Gán class active cho nút vừa click
  const clickedButton = [...buttons].find((btn) =>
    btn.getAttribute("onclick")?.includes(tab_data)
  );
  if (clickedButton) {
    clickedButton.classList.add("active");
  }
}
