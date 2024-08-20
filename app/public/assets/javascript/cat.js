$(document).ready(function() {
    $("#searchInput").on("keyup", function() {
        const value = $(this).val().toLowerCase();
        $("#categoriesTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});