<?php
// Leer los datos de empleados desde el archivo
$archivo_empleados = "empleados.txt";
if (file_exists($archivo_empleados)) {
    $empleados_json = file_get_contents($archivo_empleados);
    $empleados = json_decode($empleados_json, true);
} else {
    $empleados = array();
}

// Obtener el ID del empleado a modificar
if (isset($_GET['id'])) {
    $empleado_id = $_GET['id'];
} else {
    // Si no se proporciona el ID del empleado, redirigir a la página de consulta de empleados
    header('Location: consulta_empleados.php');
    exit();
}

// Buscar el empleado en la lista
$empleado = null;
foreach ($empleados as $empleado_actual) {
    if ($empleado_actual['id_empleado'] === $empleado_id) {
        $empleado = $empleado_actual;
        break;
    }
}

// Verificar si se ha enviado el formulario para actualizar los datos del empleado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que se hayan enviado todos los campos del formulario
    if (
        !empty($_POST['rfc']) &&
        !empty($_POST['tipo_contrato']) &&
        !empty($_POST['nombre']) &&
        !empty($_POST['apellido']) &&
        !empty($_POST['puesto']) &&
        !empty($_POST['modo_pago']) &&
        !empty($_POST['correo_electronico'])
    ) {
        // Actualizar los datos del empleado
        $empleado['rfc'] = $_POST['rfc'];
        $empleado['tipo_contrato'] = $_POST['tipo_contrato'];
        $empleado['nombre'] = $_POST['nombre'];
        $empleado['apellido'] = $_POST['apellido'];
        $empleado['puesto'] = $_POST['puesto'];
        $empleado['modo_pago'] = $_POST['modo_pago'];
        $empleado['correo_electronico'] = $_POST['correo_electronico'];
        
        // Actualizar el empleado en la lista
        foreach ($empleados as &$empleado_actual) {
            if ($empleado_actual['id_empleado'] === $empleado_id) {
                $empleado_actual = $empleado;
                break;
            }
        }
        
        // Guardar los cambios en el archivo
        $empleados_json = json_encode($empleados);
        file_put_contents($archivo_empleados, $empleados_json);
        
        // Redirigir a la página de consulta de empleados
        header('Location: consulta_empleados.php');
        exit();
    } else {
        $error = "Por favor, llene todos los campos del formulario.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="diseño2.css">
    <title>Modificar Empleado</title>
</head>
<body>
    <div id="portada">
        <!-- Agregar elementos aquí -->
    </div>
    <ul>
        <li><a href="inicio.php">&nbsp;&nbsp;PAGINA PRINCIPAL</a></li>
        <li><a href="nomina.php">&nbsp;&nbsp;&nbsp;&nbsp;SISTEMA NOMINA</a></li>
        <li><a href="alta_empleado.php">&nbsp;&nbsp;&nbsp;&nbsp;EMPLEADOS</a></li>
        <li><a href="consulta_empleados.php">&nbsp;&nbsp;&nbsp;&nbsp;CONSULTAR EMPLEADOS</a></li>
    </ul>

    <h1>Modificar Empleado</h1>

    <?php if ($empleado): ?>
        <form method="POST">
            <!-- Campos del formulario -->
            <label for="rfc">RFC:</label>
            <input type="text" name="rfc" value="<?php echo $empleado['rfc']; ?>" required>

            <label for="tipo_contrato">Tipo de contrato:</label>
            <input type="text" name="tipo_contrato" value="<?php echo $empleado['tipo_contrato']; ?>" required>

            <br><br>

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $empleado['nombre']; ?>" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" value="<?php echo $empleado['apellido']; ?>" required>

            <br><br>

            <label for="puesto">Puesto:</label>
            <input type="text" name="puesto" value="<?php echo $empleado['puesto']; ?>" required>

            <label for="modo_pago">Modo de pago:</label>
            <input type="text" name="modo_pago" value="<?php echo $empleado['modo_pago']; ?>" required>

            <br><br>

            <label for="correo_electronico">Correo electrónico:</label>
            <input type="email" name="correo_electronico" value="<?php echo $empleado['correo_electronico']; ?>" required>

            <!-- Botón para enviar el formulario -->
            <button type="submit">Actualizar</button>
        </form>
    <?php else: ?>
        <p>No se encontró el empleado.</p>
    <?php endif; ?>

    <!-- Mostrar mensaje de error si es que existe -->
    <?php if (isset($error)): ?>
        <p><?php echo $error ?></p>
    <?php endif; ?>
</body>
</html>