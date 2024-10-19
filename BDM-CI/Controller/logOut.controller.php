<?php

session_unset(); // Borra las variables de sesión
session_destroy(); // Destruye la sesión

header("Location: /BDM-CI/signUp");
exit;
?>