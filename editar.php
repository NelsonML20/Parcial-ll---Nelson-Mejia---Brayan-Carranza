<?php
session_start();
// Seguridad: Solo el administrador puede entrar a esta página
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include 'conexion.php';

// 1. OBTENER LOS DATOS ACTUALES PARA RELLENAR EL FORMULARIO
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $resultado = $conexion->query("SELECT * FROM asistencia WHERE id = $id");
    $fila = $resultado->fetch_assoc();
    
    // Si no existe el registro, volvemos al index
    if (!$fila) { header("Location: index.php"); exit(); }
}

// 2. PROCESAR LA ACTUALIZACIÓN CUANDO SE PRESIONA EL BOTÓN
if (isset($_POST['btn_actualizar'])) {
    $id_update = $_POST['txt_id'];
    $paciente = $_POST['txt_paciente'];
    $diagnostico = $_POST['txt_diagnostico'];
    $medicamento = $_POST['txt_medicamento'];

    $sql_update = "UPDATE asistencia SET 
                   paciente = '$paciente', 
                   diagnostico = '$diagnostico', 
                   medicamento = '$medicamento' 
                   WHERE id = $id_update";

    if ($conexion->query($sql_update) === TRUE) {
        header("Location: index.php?msg=actualizado");
        exit();
    } else {
        $error = "Error al actualizar: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Asistencia - Farmacia La Buena</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="align-items: center;">
    <h2>Modificar Registro Médico</h2>
    
    <?php if (isset($error)): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="editar.php?id=<?php echo $fila['id']; ?>">
        <input type="hidden" name="txt_id" value="<?php echo $fila['id']; ?>">

        <label>Nombre del Paciente:</label>
        <input type="text" name="txt_paciente" value="<?php echo htmlspecialchars($fila['paciente']); ?>" required>

        <label>Diagnóstico:</label>
        <input type="text" name="txt_diagnostico" value="<?php echo htmlspecialchars($fila['diagnostico']); ?>" required>

        <label>Medicamento Recetado:</label>
        <input type="text" name="txt_medicamento" value="<?php echo htmlspecialchars($fila['medicamento']); ?>" required>

        <button type="submit" name="btn_actualizar">Actualizar Registro</button>
        <a href="index.php" style="text-align: center; display: block; margin-top: 10px;">Cancelar</a>
    </form>
</body>
</html>