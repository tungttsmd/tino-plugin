class AjaxPackSender {
  static make(dataPackages) {
    return new AjaxPackSender(dataPackages);
  }
  constructor(dataPackages) {
    if (dataPackages !== undefined) {
      this.config = dataPackages;
    }
  }
  send() {
    jQuery.ajax({
      url: this.config.url,
      data: this.config.data,
      method: this.config.method,
      success: this.config.success,
      error: this.config.error,
      dataType: this.config.dataType || "json",
    });
  }
}
