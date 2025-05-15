const succesInvoiceDraw = function (res) {
  const currentUrl = window.location.origin + window.location.pathname;
  const config_invoiceUrl = res.hoadonUrl;
  var newUrl = currentUrl + "?invoice=" + res.invoiceID;
  if (config_invoiceUrl) {
    newUrl = config_invoiceUrl + "?invoice=" + res.invoiceID;
  }
  const noload = jQuery("#noload").val("load");
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
};
const errorInvoiceDraw = function (res, b, c) {
  console.log(res, b, c);
};

function ajaxpost(event) {
  event.preventDefault();
  const paymentOrderAjaxPackData = {
    action: "DOMAINPAYMENT",
    ajaxConfirm: "true",
    domainInput: jQuery("#domainInput").val(),
  };
  let paymentDomainData = DataPackBuilder.make()
    .set("url", ajaxPackages.adminAjaxUrl)
    .set("method", "POST")
    .set("data", paymentOrderAjaxPackData)
    .set("success", succesInvoiceDraw)
    .set("error", errorInvoiceDraw)
    .build();
  AjaxPack.make(paymentDomainData).send();
}
function confirmAndSubmitToNewTab(event, domainName) {
  event.preventDefault();
  if (confirm("Tên miền: " + domainName + ". Xác nhận đặt hàng?")) {
    const domainOrderAjaxPackData = {
      action: "DOMAINORDER",
      ajaxConfirm: "true",
      domain: jQuery("#domainInput").val(),
      button: "orderConfirm",
    };
    let orderDomainData = DataPackBuilder.make()
      .set("url", ajaxPackages.adminAjaxUrl)
      .set("method", "POST")
      .set("data", domainOrderAjaxPackData)
      .set("success", succesInvoiceDraw)
      .set("error", errorInvoiceDraw)
      .build();
    AjaxPack.make(orderDomainData).send();
  } else {
    return false;
  }
}
function submitToSameTab(event) {
  const form = document.getElementById("orderForm");
  form.target = "_self"; // gửi trong tab hiện tại
  form.submit();
}
