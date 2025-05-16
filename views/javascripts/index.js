const divStop = "drawHere";
const hiddenButton = "buttonPOSTsend";
const hiddenDomainInput = "domainInput";
const getDraw = "getDraw";
const waitingOrder = "tinoPluginAlert";
const orderNewButton = "orderNewButton";
const orderPaymentButton = "orderPaymentButton";

const succesInvoiceDraw = function (res) {
  const currentUrl = window.location.origin + window.location.pathname;
  const config_invoiceUrl = res.hoadonUrl;
  var newUrl = currentUrl + "?invoice=" + res.invoiceID;
  if (config_invoiceUrl) {
    newUrl = config_invoiceUrl + "?invoice=" + res.invoiceID;
  }
  const noload = jQuery("#noload").val("load");
  const form = document.getElementById("orderForm");

  form.action = newUrl;
  form.target = "_blank"; // Mở trong tab mới
  form.submit();

  pointerStopWaitPayment();
};
const succesOrderReload = function (res) {
  const currentUrl = window.location.origin + window.location.pathname;
  const config_invoiceUrl = res.hoadonUrl;
  var newUrl = currentUrl + "?invoice=" + res.invoiceID;
  if (config_invoiceUrl) {
    newUrl = config_invoiceUrl + "?invoice=" + res.invoiceID;
  }
  const noload = jQuery("#noload").val("load");
  const form = document.getElementById("orderForm");

  form.action = newUrl;
  form.target = "_blank"; // Mở trong tab mới
  form.submit();

  pointerStopWaitOrder();
};
const errorInvoiceDraw = function (a, b, c) {
  console.log(a);
  console.log(b);
  console.log(c);
};

function ajaxpost(event) {
  event.preventDefault();
  pointerStop();
  waitMe();
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
    pointerStop();
    waitMe();

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
      .set("success", succesOrderReload)
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

function ajaxNewForm(event) {
  event.preventDefault();
  waitMe();
  const xxx = {
    action: "ORDERNEWFORM",
    domainAjax: jQuery("#domainInput").val(),
  };
  let paymentDomainData = DataPackBuilder.make()
    .set("url", ajaxPackages.adminAjaxUrl)
    .set("method", "POST")
    .set("data", xxx)
    .set("dataType", "html")
    .set("success", function (res) {
      jQuery("#" + divStop).html(res);
    })
    .set("error", errorInvoiceDraw)
    .build();
  AjaxPack.make(paymentDomainData).send();
}
function ajaxCheckForm(event) {
  event.preventDefault();
  checkerStop();
  waitMe();
  const xxx = {
    action: "ORDERCHECKFORM",
    domainAjax: jQuery("#domainInput").val(),
  };
  let paymentDomainData = DataPackBuilder.make()
    .set("url", ajaxPackages.adminAjaxUrl)
    .set("method", "POST")
    .set("data", xxx)
    .set("dataType", "html")
    .set("success", function (res) {
      jQuery("#" + divStop).html(res);
      pointerStopRestore();
    })
    .set("error", errorInvoiceDraw)
    .build();
  AjaxPack.make(paymentDomainData).send();
}
function ajaxNewFormInOrder() {
  waitMe();
  const xxx = {
    action: "ORDERNEWFORM",
    domainAjax: jQuery("#domainInput").val(),
  };
  let paymentDomainData = DataPackBuilder.make()
    .set("url", ajaxPackages.adminAjaxUrl)
    .set("method", "POST")
    .set("data", xxx)
    .set("dataType", "html")
    .set("success", function (res) {
      jQuery("#" + divStop).html(res);
    })
    .set("error", errorInvoiceDraw)
    .build();
  AjaxPack.make(paymentDomainData).send();
}

function checkerStop() {
  jQuery("#" + divStop).css("pointer-events", "none");
  jQuery("#" + divStop).css("opacity", "0.5");
  jQuery("#" + hiddenButton).val("orderNew");
  jQuery("#" + hiddenDomainInput).val(jQuery("#domain").val());
}
function pointerStop() {
  jQuery("#" + divStop).css("pointer-events", "none");
  jQuery("#" + divStop).css("opacity", "0.5");
}
function waitMe() {
  const messenge =
    "Quá trình này có thể mất một lát ... cảm ơn vì đã kiên nhẫn";
  jQuery("#" + waitingOrder).css("display", "block");
  jQuery("#" + waitingOrder).text(messenge);
}

function pointerStopWaitOrder() {
  waitMe();
  jQuery("#" + waitingOrder).text("Đang đợi thanh toán...");
  jQuery("#" + orderNewButton).css("display", "none");
  jQuery("#" + divStop).css("pointer-events", "auto");
  jQuery("#" + divStop).css("opacity", "1");
}
function pointerStopRestore() {
  jQuery("#" + divStop).css("pointer-events", "auto");
  jQuery("#" + divStop).css("opacity", "1");
}
function pointerStopWaitPayment() {
  jQuery("#" + waitingOrder).text("Đang đợi thanh toán...");
  jQuery("#" + orderPaymentButton).css("display", "none");
  jQuery("#" + divStop).css("pointer-events", "auto");
  jQuery("#" + divStop).css("opacity", "1");
}
