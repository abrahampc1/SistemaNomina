<?php
// Leer los datos de empleados desde el archivo
$archivo_empleados = "empleados.txt";
if (file_exists($archivo_empleados)) {
    $empleados_json = file_get_contents($archivo_empleados);
    $empleados = json_decode($empleados_json, true);
} else {
    $empleados = array();
}
// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $empleado = $_POST['empleado'];
    $fecha = $_POST['fecha'];
    $periodo = $_POST['periodo'];
    $dias_pagados = $_POST['dias_pagados'];
    $tipo_pago = $_POST['tipo_pago'];
    $sueldo_base = $_POST['sueldo_base'];
    $puntualidad = $_POST['puntualidad'] / 100; // Convertir el porcentaje a decimal
    $vales_despensa = $_POST['vales_despensa'] / 100; // Convertir el porcentaje a decimal
    $isr = $_POST['isr'] / 100; // Convertir el porcentaje a decimal
    $imss = $_POST['imss'] / 100; // Convertir el porcentaje a decimal
    $infonavit = $_POST['infonavit'] / 100; // Convertir el porcentaje a decimal
    $caja_ahorro = $_POST['caja_ahorro'] / 100; // Convertir el porcentaje a decimal
    $fecha_inicial = $_POST['fecha_inicial'];
    $fecha_final = $_POST['fecha_final'];

    // Incluir la librería TCPDF
    require_once('tcpdf/tcpdf.php');

    // Crear un objeto TCPDF con orientación horizontal
    $pdf = new TCPDF('L', 'mm', 'Letter', true, 'UTF-8', false);

    // Agregar una página
    $pdf->AddPage();

    // Establecer el tipo de letra y tamaño
    $pdf->SetFont('dejavusans', '', 10);

    // Agregar el contenido al PDF
    $html = "<h1>Nómina</h1>";
    $html .= "<table>";
    $html .= "<tr><td><b>Empleado:</b></td><td>$empleado</td></tr>";
    $html .= "<tr><td><b>Fecha:</b></td><td>$fecha</td></tr>";
    $html .= "<tr><td><b>Periodo:</b></td><td>$periodo</td></tr>";
    $html .= "<tr><td><b>Tipo de pago:</b></td><td>$tipo_pago</td></tr>";

    // Verificar si los campos de incapacidad no están vacíos antes de incluirlos en el contenido del PDF
    if (!empty($fecha_inicial) && !empty($fecha_final)) {
        $html .= "<tr><td><b>Fecha inicial de incapacidad:</b></td><td>$fecha_inicial</td></tr>";
        $html .= "<tr><td><b>Fecha final de incapacidad:</b></td><td>$fecha_final</td></tr>";

        // Calcular los días de incapacidad
        $fecha_inicio = new DateTime($fecha_inicial);
        $fecha_fin = new DateTime($fecha_final);
        $dias_incapacidad = $fecha_inicio->diff($fecha_fin)->days + 1;

        // Restar los días de incapacidad a los días pagados
        $dias_pagados -= $dias_incapacidad;
    }

    // Calcular la nómina en base a los días trabajados y los porcentajes de percepciones
    $percepciones = (($puntualidad + $vales_despensa) * $sueldo_base) * $dias_pagados;

    // Calcular las deducciones en base a los porcentajes
    $deducciones = (($isr + $vales_despensa) * $sueldo_base) * $dias_pagados;

    $html .= "<tr><td><b>Sueldo base por día:</b></td><td>$sueldo_base</td></tr>";
    $html .= "<tr><td colspan='2'><h3>Percepciones</h3></td></tr>";
    $html .= "<tr><td><b>Puntualidad:</b></td><td>" . ($puntualidad * 100) . "%</td></tr>";
    $html .= "<tr><td><b>Vales de despensa:</b></td><td>" . ($vales_despensa * 100) . "%</td></tr>";
    $html .= "<tr><td><b>Total percepciones:</b></td><td>$percepciones</td></tr>";
    $html .= "<tr><td colspan='2'><h3>Deducciones</h3></td></tr>";
    $html .= "<tr><td><b>ISR:</b></td><td>" . ($isr * 100) . "%</td></tr>";
    $html .= "<tr><td><b>IMSS:</b></td><td>" . ($imss * 100) . "%</td></tr>";
    $html .= "<tr><td><b>INFONAVIT:</b></td><td>" . ($infonavit * 100) . "%</td></tr>";
    $html .= "<tr><td><b>Caja de ahorro:</b></td><td>" . ($caja_ahorro * 100) . "%</td></tr>";
    $html .= "<tr><td><b>Total deducciones:</b></td><td>$deducciones</td></tr>";

    $TotalSueldo = ($sueldo_base * $dias_pagados) + $percepciones;
    $TotalSueldo2 = $TotalSueldo - $deducciones;

    $html .= "<tr><td colspan='2'><h3>Total Nómina</h3></td></tr>";
    $html .= "<tr><td><b>Pago Total Nómina:</b></td><td>$TotalSueldo2</td></tr>";
    $html .= "</table>";

    $pdf->writeHTML($html, true, false, true, false, '');

    // Generar el archivo PDF y mostrarlo en el navegador
    $pdf->Output('nomina.pdf', 'I');
}
?>