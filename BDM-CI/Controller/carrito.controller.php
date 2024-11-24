<?php
require "Model/User.php";
require "Model/Course.php";
require "Model/Level.php";
require "Model/Cart.php";
require "Model/Inscription.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$courseDb = new Course($config['database']);
$levelDb = new Level($config['database']);
$cartDb = new Cart($config['database']);
$inscripcionesDB= new Inscription($config['database']);
if(isset($_SESSION['user'])){
    $id = $_SESSION['user']['ID_Usuario'];
    $user = $userDb->getUserById($id);
}

$carrito = $cartDb->getCartById($id);
// Enriquecer los datos del carrito con detalles de curso o nivel
$carritoEnriquecido = [];

foreach ($carrito as $item) {
    if ($item['Tipo'] === 'curso') {
        // Obtener datos del curso
        $curso = $courseDb->getCourseById($item['ID_Curso']);
        if ($curso) {
            $item['Course_Title'] = $curso['Titulo'];
            $item['Course_Image'] = $curso['Imagen'];
            $item['Course_Price'] = $curso['Costo_Total'];
            
            // Obtener datos del instructor
            $instructor = $userDb->getUserById($curso['ID_Instructor']);
            $item['Instructor_Nombre'] = $instructor['Nombre'] ?? 'N/A';
            $item['Instructor_Apellidos'] = $instructor['Apellidos'] ?? 'N/A';
        } else {
            // Datos por defecto en caso de que no se encuentre el curso
            $item['Course_Title'] = 'Curso no encontrado';
            $item['Course_Image'] = null;
            $item['Course_Price'] = 0;
            $item['Instructor_Nombre'] = 'N/A';
            $item['Instructor_Apellidos'] = 'N/A';
        }
    } elseif ($item['Tipo'] === 'nivel') {
        // Obtener datos del nivel
        $nivel = $levelDb->getLevelById($item['ID_Nivel']);
        if ($nivel) {
            $item['Level_Title'] = $nivel['Titulo'];
            $item['Level_Price'] = $nivel['Costo_Nivel'];
            
            // Obtener datos del curso al que pertenece el nivel
            $curso = $courseDb->getCourseById($nivel['ID_Curso']);
            if ($curso) {
                $item['Course_Title'] = $curso['Titulo'];
                
                // Obtener datos del instructor
                $instructor = $userDb->getUserById($curso['ID_Instructor']);
                $item['Instructor_Nombre'] = $instructor['Nombre'] ?? 'N/A';
                $item['Instructor_Apellidos'] = $instructor['Apellidos'] ?? 'N/A';
            } else {
                // Datos por defecto si el curso no existe
                $item['Course_Title'] = 'Curso no encontrado';
                $item['Instructor_Nombre'] = 'N/A';
                $item['Instructor_Apellidos'] = 'N/A';
            }
        } else {
            // Datos por defecto si no se encuentra el nivel
            $item['Level_Title'] = 'Nivel no encontrado';
            $item['Level_Price'] = 0;
            $item['Course_Title'] = 'Curso no encontrado';
            $item['Instructor_Nombre'] = 'N/A';
            $item['Instructor_Apellidos'] = 'N/A';
        }
        $item['Course_Image'] = null; // Niveles no tienen imagen
    }
    $carritoEnriquecido[] = $item;
}


$total = $cartDb->getTotal($id);
$totalAmount = $total['Total']; // Acceso más directo


// Verificar si PayerID está presente en el GET
if (isset($_GET['PayerID']) && !empty($_GET['PayerID'])) {
    $paypalCompleted = true;
} else {
    $paypalCompleted = false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $items = $_POST['items'] ?? [];
    $pagado = $_POST['Pagado'] ?? [];
    $user_id = $_POST['user_id'] ?? null;

    try {
        // Procesar los elementos enviados
        foreach ($items as $tipo => $ids) {
            foreach ($ids as $index => $id) {
                $monto_pagado = $pagado[$tipo][$index] ?? 0; // Monto pagado correspondiente
                $monto_pagado = str_replace(',', '', $monto_pagado); // Elimina las comas
                // Agregar el item a la base de datos dependiendo del tipo
                $inserted = false;
                if ($tipo === 'curso') {
                    // Agregar curso a inscripciones
                    $inserted = $inscripcionesDB->agregarCurso($id, $user_id, $monto_pagado);
                } elseif ($tipo === 'nivel') {
                    // Agregar nivel a inscripciones
                    $inserted = $inscripcionesDB->agregarNivel($id, $user_id, $monto_pagado);
                }

                // Solo actualizamos el estado si se insertó exitosamente en la base de datos
                if ($inserted) {
                    if ($tipo === 'curso') {
                        // Verificar si es un curso gratuito (monto_pagado == 0)
                        if ($monto_pagado > 0) {
                            // Si el curso tiene un pago, actualizar estado a "pagado" (0)
                            $cartDb->updateStatusByCourseId($id, 0);
                        } else {
                            // Si es gratuito, asignar un estado especial "gratuito"
                            $cartDb->updateStatusByCourseId($id, 2);  // Ejemplo: 2 puede ser el estado para "gratuito"
                        }
                    } elseif ($tipo === 'nivel') {
                        // Verificar si es un nivel gratuito (monto_pagado == 0)
                        if ($monto_pagado > 0) {
                            // Si el nivel tiene un pago, actualizar estado a "pagado" (0)
                            $cartDb->updateStatusByLevelId($id, 0);
                        } else {
                            // Si es gratuito, asignar un estado especial "gratuito"
                            $cartDb->updateStatusByLevelId($id, 2);  // Ejemplo: 2 puede ser el estado para "gratuito"
                        }
                        $inscripcionesDB->procesarLog();

                    }
                }
            }
        }
    } catch (PDOException $e) {
        // Manejar errores
        $_SESSION['mensaje'] = [
            'type' => 'error',
            'text' => 'Error al agregar los items a la base de datos: Posible compra duplicada.'
        ];
        header('Location: /BDM-CI/carrito');
        exit;
    }

    // Redireccionar después de procesar
    $_SESSION['mensaje'] = [
        'type' => 'success',
        'text' => 'Pago realizado correctamente. Los cursos/niveles han sido agregados a tus inscripciones.'
    ];
    header('Location: /BDM-CI/carrito');
    exit;
}
if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}
require "Views/carrito.view.php";