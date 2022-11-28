<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles_pdf.css">
    <title>Reporte PrestamosPDF</title>
    
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div><img class="logo fl-left" src="img/icono.png" alt=""></div>
            <h3 class="title">Instalacion de sistemas Electricos</h3>
            <div class="clear"></div>
        </div>
    </header>
    <br>
    <div class="container">
        <h4 id="report_title"> Reporte de Prestamos</h4>
        <h5 id ="subtitilo_reporte">Periodo del:&nbsp;{{$fecha1}}&nbsp;Al &nbsp; {{$fecha2}}</h5>

        <?php $count = 0; ?>
        @foreach ($datos as $item)
        <br>
            <b>Correlativo:</b> &nbsp;{{$item->correlativo}}&nbsp;&nbsp;
        </br>
            Usuario:&nbsp;{{$item->name}}
            <br>
            <b>Fecha:</b> &nbsp;{{$item->fecha_prestamo}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </br>
            <table class="table" border="1px">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Equipo</th>
                        <th>Descripcion</th>
                        <th>Marca</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach ($item->detalle as $bo)
                            <tr>
                                <td>{{$bo->codigo}}</td>
                                <td>{{$bo->equipo}}</td>    
                                <td>{{$bo->descripcion}}</td>
                                <td>{{$bo->marca}}</td>
                            </tr>
                        @endforeach    
                    </tbody>
            </table>
            <br>
            <?php $count++; ?>
        @endforeach
        <hr>
        <label>Total de Prestamos en el periodo:</label>&nbsp; <strong><br>{{$count}}
    </div>
    </br>
</body>
</html>