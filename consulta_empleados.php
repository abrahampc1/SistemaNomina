<?php
// Leer los datos de empleados desde el archivo
$archivo_empleados = "empleados.txt";
if (file_exists($archivo_empleados)) {
    $empleados_json = file_get_contents($archivo_empleados);
    $empleados = json_decode($empleados_json, true);
} else {
    $empleados = array();
}

// Verificar si se ha enviado una solicitud para eliminar un empleado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_empleado'])) {
    $empleado_id = $_POST['empleado_id'];
    
    // Buscar y eliminar el empleado de la lista
    foreach ($empleados as $key => $empleado) {
        if ($empleado['id_empleado'] === $empleado_id) {
            unset($empleados[$key]);
            break;
        }
    }
    
    // Guardar los cambios en el archivo
    $empleados_json = json_encode(array_values($empleados));
    file_put_contents($archivo_empleados, $empleados_json);
    
    // Redirigir para actualizar la página
    header('Location: consulta_empleados.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="diseño2.css">
    <title>Consultar Empleados</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
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

    <h1>CONSULTAR EMPLEADOS</h1>

    <?php if (!empty($empleados)): ?>
        <table>
            <tr>
                <th>ID de empleado</th>
                <th>RFC</th>
                <th>Tipo de contrato</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Puesto</th>
                <th>Modo de pago</th>
                <th>Correo electrónico</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?php echo $empleado['id_empleado']; ?></td>
                    <td><?php echo $empleado['rfc']; ?></td>
                    <td><?php echo $empleado['tipo_contrato']; ?></td>
                    <td><?php echo $empleado['nombre']; ?></td>
                    <td><?php echo $empleado['apellido']; ?></td>
                    <td><?php echo $empleado['puesto']; ?></td>
                    <td><?php echo $empleado['modo_pago']; ?></td>
                    <td><?php echo $empleado['correo_electronico']; ?></td>
                    <td>
                        <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="empleado_id" value="<?php echo $empleado['id_empleado']; ?>">
                            <button type="submit" name="eliminar_empleado">Eliminar</button>
                        </form>
                        <a href="modificar_empleado.php?id=<?php echo $empleado['id_empleado']; ?>">Modificar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No se encontraron empleados.</p>
    <?php endif; ?>
</body>
</html>