<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miku Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> 
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Views/dashboard.js"></script>
    <link rel="stylesheet" href="Views/dashboard.css">
    <link rel="stylesheet" href="Views/profile.css">

</head>

<body>
   <?php require 'Components/headerAdmin.php'; ?>
   <?php
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $alertType = $mensaje['type'] == 'success' ? '¡Éxito!' : 'Error';

    // Check if the message is for a successful registration
    if ($mensaje['type'] == 'success') {
        echo "<script>
            swal({
                title: '$alertType',
                text: '{$mensaje['text']}',
                type: '{$mensaje['type']}',
                showConfirmButton: true
            }, function() {
                // Redirigir a la página de iniciar sesion después de cerrar la alerta
                window.location.href = '/BDM-CI/profileAdmin';
            });
        </script>";
    } else {
        echo "<script>
            swal({
                title: '$alertType',
                text: '{$mensaje['text']}',
                type: '{$mensaje['type']}',
                showConfirmButton: true
            }, function() {
                // Redirigir a la página de logIn después de cerrar la alerta
                window.location.href = '/BDM-CI/profileAdmin';
            });
        </script>";
    }

    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}
?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <div class="profile-img">
                    <img src="<?= $fotoSrc ?>" alt="Perfil" class="profile-picture">
                </div>
                <h4><?= $user['Nombre'] ?> <?= $user['Apellidos'] ?></h4>
                <a href="#MiPerfil" class="active" data-section="profile">Mi perfil</a>
                <a href="#Cuentas" data-section="accounts">Cuentas Bloqueadas</a>
                <a href="#Categorias" data-section="categories">Categorias</a>
                <a href="/BDM-CI/reporteUsuarios" class="external-link">Reporte Usuarios</a>
            </div>

            <!-- Profile form -->
            <div class="col-md-9" id="contentArea">
                <div class="profile-container" id="profileContent">
                    <h2>Editar Perfil</h2>
                    <form id="profileForm" class="needs-validation" method="POST" action="/BDM-CI/profileAdmin" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="id" value="<?= $user['ID_Usuario'] ?>">
                        <input type="hidden" name="_method" value="PATCH">

                        <!-- Nombre y Apellido -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="<?= htmlspecialchars($user['Nombre']) ?>" required>
                                <div class="invalid-feedback">Ingresa tu nombre.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="<?= htmlspecialchars($user['Apellidos']) ?>" required>
                                <div class="invalid-feedback">Ingresa tu apellido.</div>
                            </div>
                        </div>

                        <!-- Género -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Género</label>
                                <select id="gender" class="form-select" name="gender">
                                    <option value="Masculino" <?= $user['Genero'] == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="Femenino" <?= $user['Genero'] == 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                                    <option value="Otro" <?= $user['Genero'] == 'Otro' ? 'selected' : '' ?>>Otro</option>
                                </select>
                                <div class="invalid-feedback">Selecciona tu género.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= htmlspecialchars($user['Fech_Nacimiento']) ?>" required>
                                <div class="invalid-feedback">Ingresa tu fecha de nacimiento.</div>
                            </div>
                        </div>

                        <!-- Foto de Perfil -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="foto" class="form-label">Foto de Perfil</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <div class="invalid-feedback">Debes seleccionar una imagen.</div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" disabled>
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese nueva contraseña">
                                <small class="form-text text-muted">Debe contener al menos 8 caracteres, una mayúscula, un número y un carácter especial.</small>
                                <div class="invalid-feedback">Ingresa una contraseña correcta.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirme la nueva contraseña">
                                <div class="invalid-feedback">Confirme su contraseña.</div>
                            </div>
                        </div>

                        <!-- Fecha de Registro y Última Modificación -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="registrationDate" class="form-label">Fecha de Registro</label>
                                <input type="text" class="form-control" id="registrationDate" value="<?= htmlspecialchars($user['Fech_Registro']) ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="lastUpdate" class="form-label">Última Modificación</label>
                                <input type="text" class="form-control" id="lastUpdate" value="<?= htmlspecialchars($user['Fech_Actualizacion']) ?>" disabled>
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
    <script src="Views/validationsProfile.js"></script>
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