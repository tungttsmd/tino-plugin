document.addEventListener("DOMContentLoaded", function () {
  const inspectBtn = document.getElementById("domainInspect");
  const toOrderBtn = document.getElementById("domainToOrder");
  if (inspectBtn) {
    inspectBtn.addEventListener("click", domainInspect);
    toOrderBtn.addEventListener("click", domainToOrder);
  }
});
