class ButtonAction {
  static make() {
    return new ButtonAction();
  }

  constructor() {
    this.jhandler = AjaxPackHandler.make(); // Composite Style
    this.jstyle = DomainOrderStyle.make(); // Composite Style

    this.success_invoiceRender = this.jhandler.success_invoiceRender.bind(
      this.jhandler
    );
    this.success_domainOrder = this.jhandler.success_domainOrder.bind(
      this.jhandler
    );
    this.success_domainInspect = this.jhandler.success_domainInspect.bind(
      this.jhandler
    );
    this.error_consoleLog = this.jhandler.error_consoleLog.bind(this.jhandler);
  }

  invoiceRenderButton(event) {
    this.jstyle.css_preventDefault(event);
    this.jstyle.css_pointerEventNone();
    this.jstyle.css_wait();

    let data = {
      action: "DOMAINPAYMENT",
      ajaxConfirm: "true",
      domainInput: jQuery("#domainInput").val(),
    };

    let config = PackBuilder.make()
      .set("url", indexPackJs.adminAjaxUrl)
      .set("method", "POST")
      .set("data", data)
      .set("success", this.success_invoiceRender)
      .set("error", this.error_consoleLog)
      .build();

    AjaxPackSender.make(config).send();
  }
  domainOrderButton(event, domainName) {
    this.jstyle.css_preventDefault(event);

    if (confirm("Tên miền: " + domainName + ". Xác nhận đặt hàng?")) {
      this.jstyle.css_pointerEventNone();
      this.jstyle.css_wait();

      let data = {
        action: "DOMAINORDER",
        ajaxConfirm: "true",
        domain: jQuery("#domainInput").val(),
        button: "orderConfirm",
      };

      let config = PackBuilder.make()
        .set("url", indexPackJs.adminAjaxUrl)
        .set("method", "POST")
        .set("data", data)
        .set("success", this.success_domainOrder)
        .set("error", this.error_consoleLog)
        .build();

      AjaxPackSender.make(config).send();
    } else {
      return false;
    }
  }
  domainInspectButton(event) {
    this.jstyle.css_preventDefault(event);
    this.jstyle.css_pointerEventNone();
    this.jstyle.css_inputPreventDefaultSend();
    this.jstyle.css_wait();

    const data = {
      action: "ORDERCHECKFORM",
      domainAjax: jQuery("#domainInput").val(),
    };

    let config = PackBuilder.make()
      .set("url", indexPackJs.adminAjaxUrl)
      .set("method", "POST")
      .set("data", data)
      .set("dataType", "html")
      .set("success", this.success_domainInspect)
      .set("error", this.error_consoleLog)
      .build();

    AjaxPackSender.make(config).send();
  }
}