<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles_pdf.css">
    <title>Reporte mantenimientosPDF</title>

</head>
<body>
    <header class="header">
        <div class="header-content">
            <div><img class="logo fl-left" src="img/icono.png" alt=""></div>
            <h3 class="title">Instalacion de sistemas Electricos</h3>
            <div class="clear"></div>
        </div>
    </header>
    <h4 class="report-title">Reporte de Mantenimientos</h4>
    <br>
        <h5 id ="subtitilo_reporte">Periodo del:&nbsp;{{$fecha1}}&nbsp;Al &nbsp; {{$fecha2}}</h5>
        <br>
        <table class="table" border="1px">
                <thead>
                    <tr>
                        <th>Observacion</th>
                        <th>Fecha</th>
                        <th>Encargado</th>
                        <th>Equipo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; ?>
                    @foreach ($datos as $item)
                    <tr>
                        <td>{{$item->observacion}}</td>
                        <td>{{$item->fecha}}</td>
                        <td>{{$item->encargado}}</td>
                        <td>{{$item->equipo}}</td>
                    </tr>
                    <?php $count++; ?>
                    @endforeach
                </tbody>              
                
            </table>
    <br>
      <label>Total de Mantenimientos en el periodo:</label>&nbsp; <strong>{{$count}}
    </br>

    <span class="pageNumber">Pagina 1</span>
    <div class="page-break"></div>

</body>
</html>