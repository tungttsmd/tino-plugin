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
      action: "ajaxRequest_invoiceRender",
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
        action: "ajaxRequest_domainOrder",
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

  domainInspectButton(event, tableCall) {
    this.jstyle.css_preventDefault(event);
    this.jstyle.css_pointerEventNone();
    this.jstyle.css_inputPreventDefaultSend();
    this.jstyle.css_wait();

    const data = {
      action: "ajaxRequest_domainInspect",
      domainAjax: jQuery("#domainInput").val(),
    };

    let config = PackBuilder.make()
      .set("url", indexPackJs.adminAjaxUrl)
      .set("method", "POST")
      .set("data", data)
      .set("dataType", "json")
      .set("success", (response) => {
        this.success_domainInspect(response, tableCall);
      })
      .set("error", this.error_consoleLog)
      .build();

    AjaxPackSender.make(config).send();
  }

  suggestionCaller() {
    const data = {
      action: "ajaxRequest_suggestionGetSld",
      domainInput: jQuery("#domainInput").val(),
    };
    let config = PackBuilder.make()
      .set("url", indexPackJs.adminAjaxUrl)
      .set("method", "POST")
      .set("data", data)
      .set("dataType", "json")
      .set("success", (response) => {
        // Xoá load 2/2
        jQuery("#loadBar").html("");

        const oldSld = jQuery("#saveOldSld");
        console.log("OLD: " + oldSld.val()); //new
        console.log("SAVE: " + response.sld); //new

        var flag = true;
        if (response.sld === oldSld.val()) {
          flag = false;
        }
        if (!response.sld) {
          flag = false;
        }

        if (flag) {
          indexPackJs.listTlds.forEach((value, index) => {
            this.suggestionCellPrint(value, index, response.sld);
            // Ghi nhớ tạm sld vào input ngoài drawHere
            oldSld.val(response.sld);
            console.log("Lưu mới: " + oldSld.val()); //new
            // Thực hiện loading table
            jQuery("#suggestionSelection").html(indexPackJs.htmlLoadSuggestion);
          });
        }
      })
      .set("error", this.error_consoleLog)
      .build();

    AjaxPackSender.make(config).send();
  }
  suggestionCellPrint(tldName, number, domainInput) {
    console.log(tldName + " " + number + " " + domainInput);
    const data = {
      action: "ajaxRequest_suggestionCell",
      sld: domainInput,
      tld: tldName,
    };
    let config = PackBuilder.make()
      .set("url", indexPackJs.adminAjaxUrl)
      .set("method", "POST")
      .set("data", data)
      .set("dataType", "html")
      .set("success", (response) => {
        const a = jQuery("[data-suggestion='" + number + "']");
        a.html(response);
      })
      .set("error", this.error_consoleLog)
      .build();

    AjaxPackSender.make(config).send();
  }

  suggestionSelectionButton(event) {
    // Xoá nút tiến hành đặt hàng, yêu cầu người dùng kiểm tra lại
    this.jstyle.css_buttonDomainOrderRemove();
    this.jstyle.css_buttonInvoiceRenderRemove();
    this.jstyle.css_alertColorWarning();

    const btn = jQuery(event.currentTarget);
    const domainName = btn.data("domain-name");

    // Cái nút hidden này mới thực sự đặt hàng
    const inputDomainNameHidden = jQuery("#" + msgDomainInputHiddenBox);

    // Tìm kiếm phần tử để thay thế
    const inputDomainName = jQuery("#" + msgDomainInput);

    // Thế chỗ cho nút lựa chọn mới
    inputDomainNameHidden.val(domainName);
    inputDomainName.val(domainName);

    // Cho nút chọn domain gợi ý tự inspect
    this.domainInspectButton(event, true);
  }

  rewriteRemoveButton() {
    const elOrder = jQuery("#" + domainOrderButtonConst);
    const elPayment = jQuery("#" + invoiceRenderButtonConst);
    const elInspect = jQuery(inspectButton);

    // Lệnh này giảm tải remove
    if (elOrder.length || elPayment.length) {
      elInspect.css('display', 'inline-block');
      elInspect.css('flex', '3');
      elOrder.remove();
      elPayment.remove();
    }
  }
}
