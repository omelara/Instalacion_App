<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles_pdf.css">
    <title>empleadosPDF</title>
   
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div><img class="logo fl-left" src="img/Icono.png" alt=""></div>
            <h3 class="title">Instalacion de sistemas Electricos</h3>
            <div class="clear"></div>
        </div>
    </header>
    <h1 class="report-title">Registro de empleados</h1>
    <table class="table" border="1px">
        <thead>
            <th>Fecha registro</th>
            <th class="desc">Nombre</th>
            <th>Fecha nacimiento</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Salario</th>
            @foreach($empleados as $empleado)
                <tr>
                    <td><?=$empleado->fecha_registro?></td>
                    <td><?=$empleado->nombre?></td>
                    <td><?=$empleado->fecha_nacimiento?></td>
                    <td><?=$empleado->telefono?></td>
                    <td><?=$empleado->correo?></td>
                    <td><?=$empleado->salario?></td>
                </tr>
            @endforeach
        </thead>
    </table>

    <span class="pageNumber">Pagina 1</span>
    <div class="page-break"></div>


    <footer>
      <v-app class="bg-black">
    </footer>



</body>
</html>