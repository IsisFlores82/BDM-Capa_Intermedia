document.getElementById('searchForm').addEventListener('submit', function(event) {
        // Obtener los valores de los campos
        var category = document.getElementById('category').value;
        var title = document.getElementById('title').value.trim();
        var author = document.getElementById('author').value.trim();
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        // Verificar si todos los campos están vacíos o nulos
        if (!category && !title && !author && !startDate && !endDate) {
            // Si todos los campos están vacíos o nulos, mostrar una alerta y prevenir el envío del formulario
            event.preventDefault();
            alert("Debes llenar al menos uno de los campos para realizar la búsqueda.");
        } else {
            // Si al menos un campo tiene valor, redirigir a Search.html
            event.preventDefault(); // Prevenir comportamiento por defecto del formulario
            window.location.href = "Search.html"; // Redireccionar a la página de búsqueda
        }
    });