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
    <link rel="stylesheet" href="Views/cursarCurso.css">
</head>
<body>
<?php require 'Components/headerStudent.php'; ?>
<!-- Contenedor principal con fondo blanco y sombra -->
<div class="container my-5 course-container">
<!-- Imagen del curso -->
<img src="data:image/jpeg;base64,<?= base64_encode($infoCurso['Imagen']) ?>" alt="Curso Banner" class="course-banner mb-4">

<!-- Título del curso e instructor -->
<!-- Barra de progreso -->
<div class="progress my-4">
    <div class="progress-bar bg-success" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60% Completado</div>
</div>
    <h1><?= htmlspecialchars($infoCurso['Titulo']) ?></h1>
    <h3>Instructor: HARDCODEADO CAMBIAR DESPUES</h3> 
    <h6><?= htmlspecialchars($infoCurso['Descripcion']) ?></h6>
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
                                <li>Video: <?= htmlspecialchars($nivel['Video']); ?></li>
                                <li>Archivo: <?= htmlspecialchars($nivel['Adjunto']); ?></li>
                            </ul>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="completedLevel<?= $nivel['ID_Nivel']; ?>">
                                <label class="form-check-label" for="completedLevel<?= $nivel['ID_Nivel']; ?>">
                                    Marcar como completado
                                </label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>