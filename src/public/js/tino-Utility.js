class Utility {
  static make() {
    return new Utility();
  }

  alert(jquerySelector, color, message) {
    jQuery(jquerySelector).addClass("alert alert-" + color + " fade show");
    jQuery(jquerySelector).css("display", "block");
    jQuery(jquerySelector).html(
      message + '<button type="button" class="alertClose">&times;</button>'
    );
  }
  toggleSpinner(jquerySelector) {
    jQuery(jquerySelector).toggleClass("active");
  }
  freeze(jquerySelector) {
    jQuery(jquerySelector).css("pointer-events", "none");
    jQuery(jquerySelector).css("opacity", "0.2");
  }
  unfreeze(jquerySelector) {
    jQuery(jquerySelector).css("pointer-events", "auto");
    jQuery(jquerySelector).css("opacity", "1");
  }
  responseStatus(response) {
    if (!response.ok) {
      return response.text().then((text) => {
        throw new Error(`HTTP ${response.status}: ${text}`);
      });
    }
    return response.json();
  }
}
