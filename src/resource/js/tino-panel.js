function contactListJs() {
  document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("searchInput");
    const table = document.querySelector("#ajaxHtmlReplacer table");
    const tbody = table.querySelector("tbody");

    input.addEventListener("keyup", function () {
      const keyword = input.value.toLowerCase().trim();
      const rows = tbody.querySelectorAll("tr");

      rows.forEach((row) => {
        const name = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        if (name.includes(keyword) || email.includes(keyword)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  });
}
function orderListJs() {
  document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("searchInput");
    const table = document.querySelector("#ajaxHtmlReplacer table");
    const tbody = table.querySelector("tbody");

    input.addEventListener("keyup", function () {
      const keyword = input.value.toLowerCase().trim();
      const rows = tbody.querySelectorAll("tr");

      rows.forEach((row) => {
        const domainName = row.cells[1].textContent.toLowerCase();
        if (domainName.includes(keyword)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  });
}
