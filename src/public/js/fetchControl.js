function domainInspect(event) {
  event.preventDefault();
  const domainInput = document.getElementById("domainInput");
  const nameserverInput = document.getElementById("nameserverInput");
  const domainValue = domainInput ? domainInput.value : "";
  const nameserverValue = nameserverInput ? nameserverInput.value : "";
  const fetchBody = new URLSearchParams({
    action: "ajaxDomainInspect",
    domain: domainValue,
    nameservers: nameserverValue,
  });
  const fetchPackage = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: fetchBody,
    credentials: "same-origin",
  };
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
    })
    .catch((err) => {
      console.error("Fetch chain error:", err);
      alert("Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau.");
    });
}
function domainToOrder(event) {
  event.preventDefault();
  const domainInput = document.getElementById("domainInput");
  const nameserverInput = document.getElementById("nameserverInput");
  const domainValue = domainInput ? domainInput.value : "";
  const nameserverValue = nameserverInput ? nameserverInput.value : "";
  const fetchBody = new URLSearchParams({
    action: "ajaxDomainToOrder",
    domain: domainValue,
    nameservers: nameserverValue,
  });
  const fetchPackage = {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: fetchBody,
    credentials: "same-origin",
  };
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
    })
    .catch((err) => {
      console.error("Fetch chain error:", err);
      alert("Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau.");
    });
}
// function domainInspect(event, domainName) {
//   event.preventDefault();

//   const confirmMsg = `Tên miền: ${domainName}. Xác nhận đặt hàng?`;
//   if (!confirm(confirmMsg)) return;

// const domainInput = document.getElementById("domainInput");
// const domainValue = domainInput ? domainInput.value : "";
//   if (!domainValue) {
//     alert("Vui lòng nhập tên miền hợp lệ.");
//     return;
//   }

//   const fetchBody = new URLSearchParams({
//     action: "ajaxActionInvoice",
//     ajaxConfirm: "true",
//     domain: domainValue,
//     button: "orderConfirm",
//   });

//   const fetchPackage = {
//     method: "POST",
//     headers: {
//       "Content-Type": "application/x-www-form-urlencoded",
//     },
//     body: fetchBody,
//     credentials: "same-origin",
//   };

//   fetch(scriptReceiver.adminAjaxUrl, fetchPackage)
//     .then((response) => {
//       if (!response.ok) {
//         return response.text().then((text) => {
//           throw new Error(`HTTP ${response.status}: ${text}`);
//         });
//       }
//       return response.json();
//     })
//     .then((res) => {
//       console.log("API response:", res);

//       const currentUrl = window.location.origin + window.location.pathname;
//       let invoicePageUrl = scriptReceiver.invoicePrintUrl
//         ? `${scriptReceiver.invoicePrintUrl}?invoice=${res.invoiceID}`
//         : `${currentUrl}?invoice=${res.invoiceID}`;

//       const form = document.getElementById("orderForm");

//       form.action = invoicePageUrl;
//       form.target = "_blank";
//       form.submit();

//       form.action = currentUrl;
//       form.target = "_self";
//       form.submit();
//     })
//     .catch((err) => {
//       console.error("Fetch chain error:", err);
//       alert("Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau.");
//     });
// }
