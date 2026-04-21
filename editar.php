<?php
include 'conexion.php';
$id = $_GET['id'];
$res = $conexion->query("SELECT * FROM asistencia WHERE id=$id");
$f = $res->fetch_assoc();

if (isset($_POST['actualizar'])) {
    $pac = $_POST['paciente'];
    $diag = $_POST['diagnostico'];
    $med = $_POST['medicamento'];
    $conexion->query("UPDATE asistencia SET paciente='$pac', diagnostico='$diag', medicamento='$med' WHERE id=$id");
    header("Location: panel.php");
}
?>
<form method="POST">
    <input type="text" name="paciente" value="<?php echo $f['paciente']; ?>">
    <input type="text" name="diagnostico" value="<?php echo $f['diagnostico']; ?>">
    <input type="text" name="medicamento" value="<?php echo $f['medicamento']; ?>">
    <button type="submit" name="actualizar">Actualizar</button>
</form>