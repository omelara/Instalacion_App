<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles_pdf.css">
    <title>Reporte proyectosPDF</title>
        
</style>
   
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div><img class="logo fl-left" src="img/icono.png" alt=""></div>
            <h3 class="title">Instalacion de sistemas Electricos</h3>
            <div class="clear"></div>
        </div>
    </header>
    <h4 class="report-title">Reporte de proyectos</h4>
    <br>
        <h5 id ="subtitilo_reporte">Periodo del:&nbsp;{{$fecha1}}&nbsp;Al &nbsp; {{$fecha2}}</h5>
        <table  class="table" border="1px">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Cliente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; ?>
                    @foreach ($datos as $item)
                    <tr>
                        <td>{{$item->nombre}}</td>
                        <td>{{$item->descripcion}}</td>
                        <td>{{$item->fecha_inicio}}</td>
                        <td>{{$item->fecha_fin}}</td>
                        <td>{{$item->estado}}</td>
                        <td>{{$item->cliente}}</td>
                    </tr>
                    <?php $count++; ?>
                    @endforeach
                </tbody>              
            </table>
        <br>   
        <label>Total de Proyectos en el periodo:</label>&nbsp; <strong>{{$count}}
        </br>

     <span class="pageNumber">Pagina 1</span>
    <div class="page-break"></div>
</body>
</html>