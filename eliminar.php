<?php
include 'conexion.php';
$id = $_GET['id'];
$conexion->query("DELETE FROM asistencia WHERE id=$id");
header("Location: panel.php");
?>