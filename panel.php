<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: index.php"); }
include 'conexion.php';

// INSERTAR DATOS (CREATE)
if (isset($_POST['guardar'])) {
    $pac = $_POST['paciente'];
    $diag = $_POST['diagnostico'];
    $med = $_POST['medicamento'];
    $conexion->query("INSERT INTO asistencia (paciente, diagnostico, medicamento) VALUES ('$pac', '$diag', '$med')");
}
?>

<h2>Registro de Asistencia Médica - Farmacia La Buena</h2>
<form method="POST">
    <input type="text" name="paciente" placeholder="Nombre Paciente" required>
    <input type="text" name="diagnostico" placeholder="Diagnóstico" required>
    <input type="text" name="medicamento" placeholder="Medicamento" required>
    <button type="submit" name="guardar">Registrar</button>
</form>

<table border="1">
    <tr>
        <th>Paciente</th>
        <th>Diagnóstico</th>
        <th>Medicamento</th>
        <th>Acciones</th>
    </tr>
    <?php
    $res = $conexion->query("SELECT * FROM asistencia");
    while($f = $res->fetch_assoc()) {
        echo "<tr>
            <td>{$f['paciente']}</td>
            <td>{$f['diagnostico']}</td>
            <td>{$f['medicamento']}</td>
            <td>
                <a href='editar.php?id={$f['id']}'>Editar</a> | 
                <a href='eliminar.php?id={$f['id']}'>Eliminar</a>
            </td>
        </tr>";
    }
    ?>
</table>
<a href="salir.php">Cerrar Sesión</a>