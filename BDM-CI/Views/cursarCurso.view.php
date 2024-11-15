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
       <!-- Usar SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script> 
    <script src="Views/dashboard.js"></script>
    <link rel="stylesheet" href="Views/dashboard.css">
    <link rel="stylesheet" href="Views/cursarCurso.css">
</head>
<body>
<?php require 'Components/headerStudent.php'; ?>
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
        });
    </script>";
    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}
?>
<!-- Contenedor principal con fondo blanco y sombra -->
<div class="container my-5 course-container">
<!-- Imagen del curso -->
<img src="data:image/jpeg;base64,<?= base64_encode($infoCurso['Course_Image']) ?>" alt="Curso Banner" class="course-banner mb-4">

<!-- Título del curso e instructor -->
<!-- Barra de progreso -->
<div class="progress my-4">
    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progreso; ?>%;" 
         aria-valuenow="<?= $progreso; ?>" aria-valuemin="0" aria-valuemax="100">
        <?= round($progreso); ?>% Completado
    </div>
</div>
    <h1><?= htmlspecialchars($infoCurso['Course_Title']) ?></h1>
    <h3>Instructor: <?= htmlspecialchars($infoCurso['Instructor_Nombre']).' '.$infoCurso['Instructor_Apellidos'] ?></h3>
    <h6><?= htmlspecialchars($infoCurso['Course_Description']) ?></h6>
    <div class="accordion" id="courseLevels">
        <?php foreach ($nivelesCurso as $nivel): ?>
            <?php $habilitado = in_array($nivel['ID_Nivel'], $nivelesComprados); ?>
            <div class="accordion-item <?= $habilitado ? '' : 'disabled'; ?>">
                <h2 class="accordion-header" id="heading<?= $nivel['ID_Nivel']; ?>">
                    <button class="accordion-button <?= $habilitado ? '' : 'disabled'; ?>" 
                            type="button" 
                            <?= $habilitado ? "data-bs-toggle='collapse'" : ''; ?> 
                            data-bs-target="#collapse<?= $nivel['ID_Nivel']; ?>" 
                            aria-expanded="false" 
                            aria-controls="collapse<?= $nivel['ID_Nivel']; ?>">
                        <?= htmlspecialchars($nivel['Titulo']); ?> 
                        <?= $habilitado ? '' : '(No Poseído)'; ?>
                    </button>
                </h2>
                <?php if ($habilitado): ?>
                    <div id="collapse<?= $nivel['ID_Nivel']; ?>" 
                         class="accordion-collapse collapse" 
                         aria-labelledby="heading<?= $nivel['ID_Nivel']; ?>" 
                         data-bs-parent="#courseLevels">
                        <div class="accordion-body">
                            <ul>
                                <!-- Video -->
                                <?php if (!empty($nivel['Video'])): ?>
                                    <li>
                                        <strong>Video:</strong>
                                        <video width="100%" controls>
                                            <source src="<?= htmlspecialchars($nivel['Video']); ?>" type="video/mp4">
                                            Tu navegador no soporta la reproducción de videos.
                                        </video>
                                    </li>
                                <?php endif; ?>
                                
                                <!-- Documento -->
                                <?php if (!empty($nivel['Adjunto'])): ?>
                                    <li>
                                        <strong>Archivo:</strong>
                                        <a href="<?= htmlspecialchars($nivel['Adjunto']); ?>" 
                                           download 
                                           class="btn btn-link">
                                            Descargar Archivo
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            
                            <?php $nivelCompletado = $inscriptionDb->verificarProgresoNivel($id, $nivel['ID_Nivel']); ?>

                            <!-- Checkbox -->
                            <form method="POST" action="/BDM-CI/cursarCurso/checkLevelProgress">
                                <div class="form-check">
                                    <input type="hidden" name="ID_Nivel" value="<?= $nivel['ID_Nivel']; ?>">
                                    <input type="hidden" name="ID_Curso" value="<?= $nivel['ID_Curso']; ?>">
                                    <input type="hidden" name="ID_Usuario" value="<?= $id; ?>">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        value="1" 
                                        id="completedLevel<?= $nivel['ID_Nivel']; ?>" 
                                        name="Status" 
                                        <?= ($nivelCompletado == 1) ? 'checked disabled' : ''; ?> 
                                        onchange="this.form.submit()">
                                    <label class="form-check-label" for="completedLevel<?= $nivel['ID_Nivel']; ?>">
                                        Marcar como completado
                                    </label>
                                </div>
                            </form>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>