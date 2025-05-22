class DomainOrderStyle {
  static make() {
    return new DomainOrderStyle();
  }
  css_renderHtml(response) {
    jQuery("#" + divStop).html(response);
  }
  css_pointerEventOn() {
    jQuery("#" + divStop).css("pointer-events", "auto");
    jQuery("#" + divStop).css("opacity", "1");
    jQuery("#WaitSpinner").removeClass("WaitSpinnerActive");
  }
  css_paymentWait() {
    jQuery("#" + waitingOrder).text("Đang đợi thanh toán...");
  }
  css_buttonInvoiceRenderRemove() {
    let el = jQuery("#" + invoiceRenderButtonConst);
    if (el) {
      el.remove();
    }
  }
  css_buttonDomainOrderRemove() {
    let el = jQuery("#" + domainOrderButtonConst);
    if (el) {
      el.remove();
    }
  }
  css_pointerEventNone() {
    jQuery("#" + divStop).css("pointer-events", "none");
    jQuery("#" + divStop).css("opacity", "0.2");
  }
  css_wait() {
    const messenge =
      "Quá trình này có thể mất một lát ... cảm ơn vì đã kiên nhẫn";
    jQuery("#" + waitingOrder).css("display", "block");
    jQuery("#" + waitingOrder).text(messenge);
    jQuery("#WaitSpinner").addClass("WaitSpinnerActive");
  }
  css_inputPreventDefaultSend() {
    jQuery("#" + hiddenButton).val("orderNew");
    jQuery("#" + hiddenDomainInput).val(jQuery("#domain").val());
  }
  css_preventDefault(event) {
    event.preventDefault();
  }
  css_alertColorWarning() {
    let el = jQuery(customAlert);
    let spanEl = jQuery(spanAlert);
    console.log(el);

    if (el) {
      el.css("background-color", "#fff3cd");
      spanEl.css("color", "#664d03");
      console.log("trả lời tao");
    }
  }
}
