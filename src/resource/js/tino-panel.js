function panelSearch() {
  const input = document.getElementById("searchInput");
  const table = document.querySelector("#ajaxHtmlReplacer table");
  if (!input || !table) return;

  const tbody = table.querySelector("tbody");

  input.addEventListener("keyup", function () {
    const keyword = input.value.toLowerCase().trim();
    const rows = tbody.querySelectorAll("tr");

    rows.forEach((row) => {
      // Gộp tất cả textContent của các cell trong hàng
      const rowText = [...row.cells]
        .map((cell) => cell.textContent.toLowerCase())
        .join(" ");

      // So sánh keyword với toàn bộ nội dung dòng
      if (rowText.includes(keyword)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
}
  function sortTable(th, colIndex, type = "string") {
    const table = th.closest("table");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    // Kiểm tra trạng thái sắp xếp hiện tại
    const isCurrentlyAsc = th.classList.contains("asc");
    const isAsc = !isCurrentlyAsc;

    // Reset class asc/desc tất cả các th
    table.querySelectorAll("th").forEach((thEl) => {
      thEl.classList.remove("asc", "desc");
    });
    th.classList.add(isAsc ? "asc" : "desc");

    rows.sort((a, b) => {
      let valA = a.cells[colIndex]?.textContent.trim() ?? "";
      let valB = b.cells[colIndex]?.textContent.trim() ?? "";

      switch (type) {
        case "number":
          valA = parseFloat(valA.replace(/,/g, "")) || 0;
          valB = parseFloat(valB.replace(/,/g, "")) || 0;
          return isAsc ? valA - valB : valB - valA;

        case "date":
          valA = new Date(valA).getTime();
          valB = new Date(valB).getTime();
          return isAsc ? valA - valB : valB - valA;

        case "string":
        default:
          return isAsc
            ? valA.localeCompare(valB, "vi", { sensitivity: "base" })
            : valB.localeCompare(valA, "vi", { sensitivity: "base" });
      }
    });

    // Append lại theo thứ tự mới
    rows.forEach((row) => tbody.appendChild(row));
}
