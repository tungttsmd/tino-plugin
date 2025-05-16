class ButtonBinder {
  static make() {
    return new ButtonBinder();
  }
  constructor() {
    this.buttonAction = ButtonAction.make();
  }
  run() {
    jQuery(document).on("click", ".inspectOrderButton", (event) => {
      this.buttonAction.domainInspectButton(event);
    });
    jQuery(document).on("click", "#invoiceRenderButtonId", (event) => {
      this.buttonAction.invoiceRenderButton(event);
    });
    jQuery(document).on("click", "#domainOrderButtonId", (event) => {
      let domainName = jQuery("#domainInput").val();
      this.buttonAction.domainOrderButton(event, domainName);
    });
  }
}
