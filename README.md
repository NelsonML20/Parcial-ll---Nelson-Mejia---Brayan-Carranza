# Parcial-ll---Nelson-Mejia---Brayan-Carranza

*Nelson Javier Mejia Lemus - SMSS051024*

*Brayan Isaac Carranza Amaya - SMSS023824*

# Credenciales

Usuario: admin
Contraseña: [123]  

---

## Respuestas a Preguntas

**¿Cómo manejan la conexión a la BD y qué pasa si algunos de los datos son incorrectos? Justifiquen la manera de validación de la conexión.**

La conexión a la base de datos se maneja utilizando la extensión `mysqli` de PHP orientada a objetos. En el archivo `conexion.php`, se crea una instancia llamando a `new mysqli("localhost:3307", "root", "", "db_farmacia");`, donde se especifican el servidor, puerto, usuario, contraseña y la base de datos. 
Si alguno de los datos es incorrecto (por ejemplo, el puerto no es 3307, o el servicio no está activo), la conexión falla y la propiedad `$conexion->connect_error` almacena el detalle del fallo. 
La validación se realiza mediante un `if ($conexion->connect_error)`. Si hay error, se utiliza la función `die()` para detener completamente la ejecución de la página web y mostrar en pantalla el error. Esta validación se justifica para un entorno de desarrollo porque evita que la aplicación siga ejecutando procesos (como consultas SQL) sobre una base de datos que no está disponible, informando inmediatamente al desarrollador cuál es el problema técnico.

**¿Cuál es la diferencia entre $_GET y $_POST en PHP? ¿Cuándo es más apropiado usar cada uno? Da un ejemplo real de tu proyecto.**

La diferencia principal radica en cómo se envían los datos desde el navegador hacia el servidor.
*   **$_GET:** Transmite los datos anexándolos a la URL (haciéndolos visibles). Tiene un límite de tamaño y es menos seguro para información confidencial. Es apropiado para acciones que solo leen o solicitan datos sin modificar el estado en el servidor, como aplicar filtros o seleccionar un registro específico.
*   **$_POST:** Transmite los datos de forma oculta en el cuerpo de la petición HTTP. No tiene un tamaño límite estricto y es más seguro. Es apropiado para enviar contraseñas, información médica o cuando las acciones guardan, actualizan o borran datos del sistema.
*   **Ejemplo real del proyecto:** 
    *   **$_GET:** Se utiliza en los archivos `eliminar.php` y `editar.php` (`$id = $_GET['id'];`). Es apropiado aquí porque el ID se envía a través del enlace del botón "Eliminar" (ej. `eliminar.php?id=3`), lo cual es una forma rápida de identificar el registro a afectar.
    *   **$_POST:** Se utiliza en `login.php` (`$_POST['user']` y `$_POST['pass']`) para capturar el usuario y la contraseña del formulario de ingreso. Es fundamental usar POST aquí para que la clave no quede expuesta en la barra de direcciones del navegador. También se usa en `index.php` para guardar el registro de una nueva asistencia médica, enviando los datos sensibles del paciente.

**Tu app va a usarse en una empresa de la zona oriental. ¿Qué riesgos de seguridad identificas en una app web con BD que maneja datos de los usuarios? ¿Cómo los mitigarían?**

Al tratar con datos privados y de salud (pacientes, diagnósticos y medicamentos), identificamos varios riesgos severos en una implementación básica:
1.  **Ataques de Inyección SQL:** Los datos que llegan de `$_POST` y `$_GET` podrían usarse directamente en consultas SQL. Un empleado o atacante malintencionado podría escribir código SQL en los formularios y acceder, alterar o destruir la base de datos completa.
    *   *Mitigación:* Modificar todas las consultas (`mysqli_query`) para que usen sentencias preparadas (Prepared Statements), lo cual evita que el código SQL se combine con la información digitada.
2.  **Robo de credenciales por almacenamiento en Texto Plano:** En el script SQL se evidencia que la contraseña (`123`) se guarda tal cual. Si un atacante extrae la base de datos, tendrá acceso inmediato a las cuentas.
    *   *Mitigación:* Implementar el cifrado de contraseñas usando la función `password_hash()` de PHP al crear el usuario y `password_verify()` al momento de iniciar sesión.
3.  **Exposición de datos médicos por intercepción de red:** Si la empresa usa la aplicación mediante una red HTTP normal, cualquier persona conectada a la misma red Wi-Fi podría capturar las credenciales o los diagnósticos de los pacientes (Man-in-the-Middle).
    *   *Mitigación:* Instalar un certificado SSL/TLS en el servidor web para forzar que todas las conexiones utilicen el protocolo encriptado HTTPS.
4.  **Vulnerabilidad a Cross-Site Scripting (XSS):** Si un atacante inyecta scripts Javascript a través del campo "diagnóstico", estos podrían ejecutarse en los navegadores de otros usuarios que consulten el historial de asistencias.
    *   *Mitigación:* Aplicar la función `htmlspecialchars()` a todo texto extraído de la base de datos antes de mostrarlo en la interfaz HTML.
