<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miku Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Usar SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script> 

    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="Views/dashboard.css">
    <link rel="stylesheet" href="Views/profile.css">
</head>


<body>
   <?php require 'Components/headerInstructor.php'; ?>
<?php
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $alertType = $mensaje['type'] == 'success' ? 'success' : 'error';
    // Escapar los caracteres especiales del mensaje
    $text = htmlspecialchars($mensaje['text'], ENT_QUOTES, 'UTF-8');

    // Usando SweetAlert2 para mostrar la alerta
    echo "<script>
        Swal.fire({
            title: '$alertType',
            text: '$text',
            icon: '$alertType',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = '/BDM-CI/profileInstructor';
        });
    </script>";
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
                <a href="#Cursos" data-section="courses">Cursos Creados</a>
                <a href="/BDM-CI/reporteDeVentas" class="external-link">Reporte de Ventas</a>
                <a href="/BDM-CI/crearCurso" class="external-link">Crear Curso</a>
            </div>

            <!-- Profile form -->
            <div class="col-md-9" id="contentArea">
                <div class="profile-container" id="profileContent">
                    <h2>Editar Perfil</h2>
                    <form id="profileForm" class="needs-validation" method="POST" action="/BDM-CI/profileInstructor" enctype="multipart/form-data" novalidate>
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
                <div class="courses-container d-none" id="coursesContent">
                    <h2>Cursos Creados</h2>
                    <div class="row">
                        <?php foreach ($courses as $course): ?>
                            <?php
                                // Handle BLOB image
                                if (!empty($course['Imagen'])) {
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    $mimeType = $finfo->buffer($course['Imagen']);
                                    $fotoBase64 = base64_encode($course['Imagen']);
                                    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
                                } else {
                                    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
                                }
                            ?>
                            <div class="col-md-4 mb-3">
                                <div class="card course-item">
                                    <div class="card-body">
                                        <!-- Delete button sends a POST request with course ID for deletion -->
                                        <form method="POST" action="/BDM-CI/profileInstructor/deleteCourse" class="position-absolute top-0 end-0 m-2 delete-form">
                                            <input type="hidden" name="ID_Curso" value="<?= htmlspecialchars($course['ID_Curso']); ?>">
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">Baja</button>
                                        </form>
                            
                                        <!-- Course Image -->
                                        <img src="<?= $fotoSrc ?>" alt="Curso" class="img-fluid course-image mb-3">
                            
                                        <!-- Course Title -->
                                        <h5 class="card-title"><?= htmlspecialchars($course['Titulo']); ?></h5>
                            
                                        <!-- Edit button links to edit controller, passing course ID -->
                                        <a href="/BDM-CI/editarCurso?id=<?= htmlspecialchars($course['ID_Curso']); ?>" class="btn btn-primary">Editar Curso</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Evitar el envío inmediato del formulario
                const form = this.closest('.delete-form'); // Seleccionar el formulario relacionado con este botón
            
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'No podrás revertir esta acción.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Enviar el formulario si el usuario confirma
                    }
                });
            });
        });
    </script>
    <script src="Views/validationsProfile.js"></script>
    <script src="Views/profileInstructor.js"></script>


</body>
</html>