<!DOCTYPE html>
<html>
<head>
  <title>Formulario Nómina Empleados</title>
  <link rel="stylesheet" type="text/css" href="diseño2.css">
</head>
<body>
  <div id="portada">
    <!-- Agregar elementos aquí -->
  </div>
  <ul>
    <li><a href="inicio.php">&nbsp;&nbsp;PAGINA PRINCIPAL</a></li>
    <li><a href="nomina.php">&nbsp;&nbsp;&nbsp;&nbsp;SISTEMA NÓMINA</a></li>
    <li><a href="alta_empleado.php">&nbsp;&nbsp;&nbsp;&nbsp;EMPLEADOS</a></li>
    <li><a href="consulta_empleados.php">&nbsp;&nbsp;&nbsp;&nbsp;CONSULTAR EMPLEADOS</a></li>
  </ul>
  <h1>Formulario Nómina Empleados</h1>

  <!-- Formulario para generar una nómina -->
  <form action="generar_nomina.php" method="POST">
    <label for="empleado">Empleado:</label>
    <select name="empleado" id="empleado" required>
      <?php
        // Leer el contenido del archivo de empleados
        $contenido = file_get_contents("empleados.txt");

        // Decodificar el contenido como un array de objetos JSON
        $empleados = json_decode($contenido);
        // Verificar si la variable $empleados es null o vacía antes de recorrerla
        if (!empty($empleados)) {
          foreach ($empleados as $empleado) {
            echo "<option value='{$empleado->id}'>{$empleado->nombre} {$empleado->apellido}</option>";
          }
        } else {
          echo "<option value=''>No se encontraron empleados</option>";
        }
      ?>
    </select>
    <br>

    <!-- Campos de la nómina -->
    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" id="fecha" required>
    <br>

    <label for="periodo">Periodo:</label>
    <input type="text" name="periodo" id="periodo" required>
    <br>

    <label for="dias_pagados">Días pagados:</label>
    <input type="number" name="dias_pagados" id="dias_pagados" required>
    <br>

    <label for="tipo_pago">Tipo de pago:</label>
    <select name="tipo_pago" id="tipo_pago" required>
      <option value="Efectivo">Efectivo</option>
      <option value="Transferencia">Transferencia</option>
    </select>
    <br>

    <!-- Percepciones -->
    <h3>Percepciones</h3>
    <label for="sueldo_base">Sueldo base:</label>
    <input type="number" name="sueldo_base" id="sueldo_base" required>
    <br>

    <label for="puntualidad">Puntualidad:</label>
    <input type="number" name="puntualidad" id="puntualidad" required>
    <br>

    <label for="vales_despensa">Vales de despensa:</label>
    <input type="number" name="vales_despensa" id="vales_despensa" required>
    <br>

    <!-- Deducciones -->
    <h3>Deducciones</h3>
    <label for="isr">ISR:</label>
    <input type="number" name="isr" id="isr" required>
    <br>

    <label for="imss">IMSS:</label>
    <input type="number" name="imss" id="imss" required>
    <br>

    <label for="infonavit">INFONAVIT:</label>
    <input type="number" name="infonavit" id="infonavit" required>
    <br>

    <label for="caja_ahorro">Caja de ahorro:</label>
    <input type="number" name="caja_ahorro" id="caja_ahorro" required>
    <br>
    
    <!-- Incapacidad -->
    <h3>Incapacidad</h3>
    <label for="fecha_inicial">Fecha inicial:</label>
    <input type="date" name="fecha_inicial" id="fecha_inicial">
    <br>

    <label for="fecha_final">Fecha final:</label>
    <input type="date" name="fecha_final" id="fecha_final">
    <br>
    <br>

    <input type="submit" value="Generar nómina">
  </form>
</body>
</html>