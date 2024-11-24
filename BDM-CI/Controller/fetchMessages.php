<?php
require "Model/User.php";
require "Model/Chat.php"; // Asegúrate de tener un modelo Mensajes configurado
$config = require 'config.php';

$chatDb = new Chat($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];


$result = $chatDb->getChatMessages($sender, $receiver);

if (!empty($result)) { 
    foreach ($result as $row) {
        // Formatear la fecha
        $fechaEnvio = date("d/m/Y | H:i", strtotime($row['Fecha_Envio']));
        
        // Determinar si el mensaje es enviado o recibido
        $isSender = ($row['ID_Emisor'] == $sender); // True si el mensaje es del remitente actual

        if ($isSender) {
            // Mensaje del remitente
            echo '
            <div class="d-flex justify-content-end align-items-center text-break text-wrap me-2 mt-2">           
                <div class="message-container-me">
                    <p class="mb-0 text-secondary text-end">' . htmlspecialchars($fechaEnvio) . '</p>
                    <div class="p-2 bg-info-subtle rounded">
                        ' . htmlspecialchars($row['Mensaje']) . '
                    </div>  
                </div>                          
            </div>';
        } else {
            // Mensaje del receptor
            echo '
            <div class="row-12 d-flex justify-content-start align-items-center text-break text-wrap ms-1 mt-2">
                <div class="message-container col-7">
                    <p class="mb-0 text-secondary">' . htmlspecialchars($fechaEnvio) . '</p>
                    <div class="p-2 bg-light text-grap rounded message-container">
                        ' . htmlspecialchars($row['Mensaje']) . '
                    </div>
                </div>          
            </div>';
        }
    }
} else {
    echo '<div class="message">No hay mensajes.</div>';
}

}