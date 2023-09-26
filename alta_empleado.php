<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que se hayan enviado todos los campos del formulario
    if (
        !empty($_POST['id_empleado']) &&
        !empty($_POST['rfc']) &&
        !empty($_POST['tipo_contrato']) &&
        !empty($_POST['nombre']) &&
        !empty($_POST['apellido']) &&
        !empty($_POST['puesto']) &&
        !empty($_POST['modo_pago']) &&
        !empty($_POST['correo_electronico'])
    ) {
        // Crear arreglo asociativo con los datos del empleado
        $datos_empleado = array(
            'id_empleado' => $_POST['id_empleado'],
            'rfc' => $_POST['rfc'],
            'tipo_contrato' => $_POST['tipo_contrato'],
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'puesto' => $_POST['puesto'],
            'modo_pago' => $_POST['modo_pago'],
            'correo_electronico' => $_POST['correo_electronico']
        );

        // Leer los datos existentes de empleados desde el archivo
        $empleados = array();
        $archivo_empleados = "empleados.txt";
        if (file_exists($archivo_empleados)) {
            $empleados_json = file_get_contents($archivo_empleados);
            $empleados = json_decode($empleados_json, true);
        }

        // Agregar el nuevo empleado al array de empleados
        $empleados[] = $datos_empleado;

        // Guardar los datos en el archivo
        $empleados_json = json_encode($empleados);
        file_put_contents($archivo_empleados, $empleados_json);

        // Redirigir al usuario a una página de éxito
        header('Location: exito.php');
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
    <title>Formulario Alta Empleados</title>
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

    <h1>ALTA DE EMPLEADOS</h1>
    <form method="POST">
        <!-- Campos del formulario -->
        <label for="id_empleado">ID de empleado:</label>
        <input type="text" name="id_empleado" required>

        <label for="rfc">RFC:</label>
        <input type="text" name="rfc" required>
        <br><br>
        <label for="tipo_contrato">Tipo de contrato:</label>
        <input type="text" name="tipo_contrato" required>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <br><br>
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required>

        <label for="puesto">Puesto:</label>
        <input type="text" name="puesto" required>
        <br><br>
        <label for="modo_pago">Modo de pago:</label>
        <input type="text" name="modo_pago" required>

        <label for="correo_electronico">Correo electrónico:</label>
        <input type="email" name="correo_electronico" required>

        <!-- Botón para enviar el formulario -->
        <button type="submit">Enviar</button>
    </form>

    <!-- Mostrar mensaje de error si es que existe -->
    <?php if (isset($error)): ?>
        <p><?php echo $error ?></p>
    <?php endif ?>
</body>
</html>