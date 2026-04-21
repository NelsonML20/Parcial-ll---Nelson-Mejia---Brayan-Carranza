<?php
session_start();
// Seguridad: Si no es admin, no puede eliminar
if (!isset($_SESSION['admin'])) {
    die("Acceso denegado. No tiene permisos para realizar esta acción.");
}

include 'conexion.php';

// Verificamos que se haya enviado un ID por la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ejecutamos la sentencia de eliminación
    $sql = "DELETE FROM asistencia WHERE id = $id";

    if ($conexion->query($sql) === TRUE) {
        // Redirigimos al index con un mensaje de éxito
        header("Location: index.php?msg=eliminado");
        exit();
    } else {
        echo "Error al eliminar el registro: " . $conexion->error;
    }
} else {
    header("Location: index.php");
    exit();
}
?>
