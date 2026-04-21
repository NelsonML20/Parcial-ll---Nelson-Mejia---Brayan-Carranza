<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "db_farmacia";

$conexion = new mysqli("localhost", "root", "", "db_farmacia");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>