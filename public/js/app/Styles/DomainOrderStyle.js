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
    jQuery("#" + invoiceRenderButtonConst).remove();
  }
  css_buttonDomainOrderRemove() {
    jQuery("#" + domainOrderButtonConst).remove();
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
}
