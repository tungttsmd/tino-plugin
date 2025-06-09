function ajaxpost(event) {
  event.preventDefault();

  $.ajax({
    url: MOTHERFUCKEROBJECTAJAX.ajaxurl,
    data: {
      action: "MOTHERFUCKER",
      ajaxConfirm: "true",
      domainInput: $("#domainInput").val(),
    },
    method: "POST",
    success: function (res) {
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
    error: function (res, b, c) {
      console.log(res, b, c);
    },
  });
}
