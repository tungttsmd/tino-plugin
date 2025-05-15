class AjaxPack {
    config = null;
    constructor(dataPackages) {
      if (dataPackages !== undefined) {
        this.config = dataPackages;
      }
    }
    static make(dataPackages) {
      return new AjaxPack(dataPackages);
    }
  
    send() {
      jQuery.ajax({
        url: this.config.url,
        data: this.config.data,
        method: this.config.method,
        success: this.config.success,
        error: this.config.error,
      });
    }
  }