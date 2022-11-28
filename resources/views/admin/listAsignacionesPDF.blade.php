<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles_pdf.css">
    <title>asignacionesPDF</title>
   
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div><img class="logo fl-left" src="img/icono.png" alt=""></div>
            <h3 class="title">Instalacion de sistemas Electricos</h3>
            <div class="clear"></div>
        </div>
    </header>
    <h1 class="report-title">Reporte de Recursos</h1>
    <table class="table" border="1px">
        <thead>
            <th>Presupuesto Inicial</th>
            <th>Cantidad</th>
            <th class="desc">Fecha</th>
            <th>Equipo</th>
            <th>Proyecto</th>
            <th>Gasto Final</th>
            @foreach($asignaciones as $asignacion)
                <tr>
                    <td><?=$asignacion->presupuesto_i?></td>
                    <td><?=$asignacion->cantidad?></td>
                    <td><?=$asignacion->fecha?></td>
                    <td><?=$asignacion->equipo?></td>
                    <td><?=$asignacion->proyecto?></td>
                    <td><?=$asignacion->gasto_f?></td>
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