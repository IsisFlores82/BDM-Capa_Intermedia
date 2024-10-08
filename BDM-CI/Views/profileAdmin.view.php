<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miku Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Views/dashboard.js"></script>
    <link rel="stylesheet" href="Views/dashboard.css">
    <link rel="stylesheet" href="Views/profile.css">

</head>

<body>
   <?php require 'Components/headerAdmin.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <div class="profile-img "><img src="https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg" alt="Perfil" class="rounded-circle" width="50%" height="50%"></div>
                <h4>Carlos Daniel Pinkus Martínez</h4>
                <a href="#MiPerfil" class="active" data-section="profile">Mi perfil</a>
                <a href="#Cuentas" data-section="accounts">Cuentas Bloqueadas</a>
                <a href="#Categorias" data-section="categories">Categorias</a>
                <a href="/BDM-CI/reporteUsuarios" class="external-link">Reporte Usuarios</a>
            </div>

            <!-- Profile form -->
            <div class="col-md-9" id="contentArea">
                <div class="profile-container" id="profileContent">
                    <h2>Editar Perfil</h2>
                    <form id="profileForm">
                        <!-- Nombre y Apellido -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="firstName" value="Carlos Daniel" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="lastName" value="Pinkus Martínez" required>
                            </div>
                        </div>
                    
                        <!-- Género -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Género</label>
                                <select id="gender" class="form-select">
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="birthdate" value="1990-01-01" required>
                            </div>
                        </div>
                    
                        <!-- Foto de Perfil -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="profilePhoto" class="form-label">Foto de Perfil</label>
                                <input type="file" class="form-control" id="profilePhoto" accept="image/*">
                            </div>
                        </div>
                    
                        <!-- Email -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="carlos.pinkus@example.com" disabled>
                            </div>
                        </div>
                    
                        <!-- Contraseña -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" placeholder="Ingrese nueva contraseña">
                                <small class="form-text text-muted">Debe contener al menos 8 caracteres, una mayúscula, un número y un carácter especial.</small>
                            </div>
                            <div class="col-md-6">
                                <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirme la nueva contraseña">
                            </div>
                        </div>
                    
                        <!-- Fecha de Registro y Última Modificación (no editables) -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="registrationDate" class="form-label">Fecha de Registro</label>
                                <input type="text" class="form-control" id="registrationDate" value="2023-09-15" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="lastUpdate" class="form-label">Última Modificación</label>
                                <input type="text" class="form-control" id="lastUpdate" value="2024-09-17" disabled>
                            </div>
                        </div>
                    
                        <!-- Botón Guardar -->
                        <button type="submit" class="btn btn-save">Guardar</button>
                    </form>
                </div>
                <div class="courses-container d-none" id="accountsContent">
                    <h2>Cuentas Bloqueadas</h2>
                    <div class="row">
                    </div>
                </div>
                <div class="categories-container d-none" id="categoriesContent">
                    <h2>Categorías</h2>
                    <form id="categoriesForm">
                        <div id="categoryList">
                            
                        </div>
                        <button type="button" class="btn btn-primary mt-3" onclick="addCategory()">Agregar Categoría</button>
                        <button type="submit" class="btn btn-success mt-3">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmRehabilitate() {
    const confirmAction = confirm("¿Estás seguro de que deseas rehabilitara este usuario?");
    if (confirmAction) {
        alert("El usuario ha sido rehabilitado.");
    } else {
        alert("Rehabilitacion cancelada.");
    }
    }
    
    function addCategoryToDOM(name, description, index) {
    const categoryList = document.getElementById('categoryList');
    const categoryItem = document.createElement('div');
    categoryItem.classList.add('row', 'mb-3');
    categoryItem.setAttribute('data-index', index);

    categoryItem.innerHTML = `
        <div class="col-md-5">
            <label class="form-label">Nombre de la Categoría</label>
            <input type="text" class="form-control" name="categoryName" value="${name}" required>
        </div>
        <div class="col-md-5">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="categoryDescription" value="${description}" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-danger" onclick="removeCategory(this)">Eliminar</button>
        </div>
    `;

    categoryList.appendChild(categoryItem);
}

    // Función para agregar nueva categoría
    function addCategory() {
        addCategoryToDOM('Nueva Categoría', 'Descripción de la Categoría', document.getElementById('categoryList').children.length);
    }
    // Función para eliminar una categoría
    function removeCategory(button) {
        const categoryItem = button.closest('.row');
        categoryItem.remove();
    }
    
    function saveCategories(event) {
    event.preventDefault(); // Previene el envío automático del formulario

    const form = document.getElementById('categoriesForm');

    // Verificar si el formulario es válido
    if (form.checkValidity()) {
        alert('Los cambios han sido guardados');
    } else {
        // Si no es válido, mostrar el comportamiento de validación por defecto del navegador
        form.reportValidity();
    }
}
    </script>
   <script src="Views/profileAdmin.js"></script>

</body>
</html>