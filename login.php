<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    
    $sql = "SELECT * FROM usuarios WHERE usuario='$user' AND clave='$pass'";
    $res = $conexion->query($sql);
    
    if ($res->num_rows > 0) {
        $_SESSION['admin'] = $user;
        header("Location: panel.php");
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>
<form method="POST">
    <h2>Login Administrativo</h2>
    <input type="text" name="user" placeholder="Usuario" required>
    <input type="password" name="pass" placeholder="Clave" required>
    <button type="submit">Entrar</button>
    <br><a href="panel.php">Regresar como invitado</a>
</form>