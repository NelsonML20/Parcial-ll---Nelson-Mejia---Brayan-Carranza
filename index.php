<?php
session_start();
include 'conexion.php';

// Procesar inicio de sesión si se envió el formulario de login
$error_login = "";
if (isset($_POST['btn_login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    
    $sql = "SELECT * FROM usuarios WHERE usuario='$user' AND clave='$pass'";
    $res = $conexion->query($sql);
    
    if ($res->num_rows > 0) {
        $_SESSION['admin'] = $user;
        header("Location: index.php");
        exit();
    } else {
        $error_login = "Credenciales incorrectas.";
    }
}

// Verificar si hay una sesión activa
$es_admin = isset($_SESSION['admin']);

// Lógica de Insertar (Solo si es admin)
if ($es_admin && isset($_POST['guardar'])) {
    $pac = $_POST['paciente'];
    $diag = $_POST['diagnostico'];
    $med = $_POST['medicamento'];
    $conexion->query("INSERT INTO asistencia (paciente, diagnostico, medicamento) VALUES ('$pac', '$diag', '$med')");
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacia La Buena - Asistencia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Farmacia La Buena - Sistema de Asistencia</h2>

    <?php if (!$es_admin): ?>
        <!-- Formulario de Login para usuarios no registrados -->
        <form method="POST" style="margin-bottom: 20px;">
            <h3>Iniciar Sesión (Administradores)</h3>
            <?php if ($error_login): ?>
                <div class="error-msg"><?php echo $error_login; ?></div>
            <?php endif; ?>
            <input type="text" name="user" placeholder="Usuario" required>
            <input type="password" name="pass" placeholder="Clave" required>
            <button type="submit" name="btn_login">Entrar</button>
        </form>
    <?php else: ?>
        <!-- Formulario de Registro para el Administrador -->
        <div style="text-align: center; margin-bottom: 10px;">
            <p>Bienvenido, <strong><?php echo $_SESSION['admin']; ?></strong> | <a href="cerrar_sesion.php" class="logout-link" style="margin-top: 0; padding: 5px 10px;">Cerrar Sesión</a></p>
        </div>

        <form method="POST" style="margin-bottom: 20px;">
            <h3>Registrar Nueva Asistencia</h3>
            <input type="text" name="paciente" placeholder="Nombre del Paciente" required>
            <input type="text" name="diagnostico" placeholder="Diagnóstico" required>
            <input type="text" name="medicamento" placeholder="Medicamento" required>
            <button type="submit" name="guardar">Guardar Registro</button>
        </form>
    <?php endif; ?>

    <h3>Listado de Asistencias Médicas</h3>
    <table>
        <tr>
            <th>Paciente</th>
            <th>Diagnóstico</th>
            <th>Medicamento</th>
            <?php if ($es_admin): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>
        <?php
        // La tabla va ordenada con los datos respectivos (por id de forma descendente para ver los más recientes)
        $res = $conexion->query("SELECT * FROM asistencia ORDER BY id DESC");
        while ($f = $res->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($f['paciente']) . "</td>
                    <td>" . htmlspecialchars($f['diagnostico']) . "</td>
                    <td>" . htmlspecialchars($f['medicamento']) . "</td>";

            if ($es_admin) {
                echo "<td>
                        <a href='editar.php?id={$f['id']}'>Editar</a> | 
                        <a href='eliminar.php?id={$f['id']}'>Eliminar</a>
                      </td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>