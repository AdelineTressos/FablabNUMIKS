document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector('input[name="search"]');
  const rows = document.querySelectorAll("table tbody tr");

  searchInput.addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();

    rows.forEach((row) => {
      const name = row.getAttribute("data-name").toLowerCase();
      if (name.startsWith(searchValue)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const tableBody = document.querySelector("table tbody");
  const rows = Array.from(tableBody.querySelectorAll("tr"));

  // Séparer les lignes en deux groupes
  const highlightedRows = rows.filter((row) =>
    row.classList.contains("table-danger")
  );
  const normalRows = rows.filter(
    (row) => !row.classList.contains("table-danger")
  );

  // Vider le tableau
  while (tableBody.firstChild) {
    tableBody.removeChild(tableBody.firstChild);
  }

  // Réinsérer les lignes, en mettant d'abord les lignes à mettre en évidence
  [...highlightedRows, ...normalRows].forEach((row) =>
    tableBody.appendChild(row)
  );

  // Logique de recherche réactive (si déjà implémentée)
  const searchInput = document.querySelector('input[name="search"]');
  searchInput.addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();
    rows.forEach((row) => {
      const name = row.dataset.name.toLowerCase();
      if (name.startsWith(searchValue)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
});
