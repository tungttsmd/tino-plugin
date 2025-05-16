class AjaxPackHandler {
  static make() {
    return new AjaxPackHandler();
  }
  constructor() {
    this.jstyle = DomainOrderStyle.make(); // Composite Style
  }
  success_invoiceRender(response) {
    this.success_actions(response);
    this.jstyle.css_buttonInvoiceRenderRemove();
  }
  success_domainOrder(response) {
    this.success_actions(response);
    this.jstyle.css_buttonDomainOrderRemove();
  }
  success_domainInspect(response) {
      this.jstyle.css_renderHtml(response);
      this.jstyle.css_pointerEventOn();
  }
  error_consoleLog(jqXHR, textStatus, errorThrown) {
    console.log("AjaxPackHandler chạy Ajax thất bại.");
    console.log("Dòng lỗi jqXHR: ", jqXHR);
    console.log("Trạng thái: ", textStatus);
    console.log("Chi tiết lỗi: ", errorThrown);
  }
  success_actions(response) {
    const currentUrl = window.location.origin + window.location.pathname;
    const config_invoiceUrl = response.hoadonUrl;
    var newUrl = currentUrl + "?invoice=" + response.invoiceID;
    if (config_invoiceUrl) {
      newUrl = config_invoiceUrl + "?invoice=" + response.invoiceID;
    }
    const form = document.getElementById("orderForm");
    jQuery("#noload").val("load");

    form.action = newUrl;
    form.target = "_blank"; // Mở trong tab mới
    form.submit();

    this.jstyle.css_pointerEventOn();
    this.jstyle.css_paymentWait();
  }
}
