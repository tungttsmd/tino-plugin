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
  success_domainInspect(response, tableCall) {
    // tableCall là một tham số được truyền cho phép kiểm tra domain nhưng không reload suggestion table
    // miễn tableCall không undefined là được
    let flag = true;
    if (tableCall != undefined || tableCall == false) {
      flag = false;
    }

    // this này đã bị bind ở bên sử dụng duy nhất của nó, this này không phải là AjaxPackHandler mà là ButtonAction
    // Trùng hợp ButtonAction cũng có jstyle.css... y chang nên trùng
    this.jstyle.css_renderHtml(response.html);
    this.jstyle.css_pointerEventOn();

    // Tạo UI UX
    jQuery("#loadBar").html(indexPackJs.htmlLoadBar);

    // Bind this là để gọi cái này ở buttonAction,
    // Tại khởi tạo ButtonAction thì trong constructor của nó lại khởi tạo AjaxPackHandler Gây ra vòng lặp vô hạn
    // Nên bind this là xài trực tiếp method bên kia luôn
    if (flag && response.suggestionStatus) {
      const domainInputParam = jQuery("#" + hiddenDomainInput).val();
      this.buttonActionInstance = ButtonAction.make();
      this.buttonActionInstance.suggestionCaller(domainInputParam);
    } else {
      // Xoá load 1/2
      jQuery("#loadBar").html("");
    }
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
