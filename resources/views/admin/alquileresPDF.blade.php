<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportar a PDF </title>
    <link rel="stylesheet" href="css/alquileres_pdf.css">
</head>
<body>
    <header>
        <div class="header_logo">
            <img class="logo fl-left" src="img/Icono.png" alt="">
        </div>
        <h3>InstalacionSE</h3>
    </header>
    <br>
    <div class="container">
        <h4 id="titulo_reporte"> Reporte de Alquileres</h4>
        <h5 id ="subtitilo_reporte">Periodo del:&nbsp;{{$fecha1}}&nbsp;Al &nbsp; {{$fecha2}}</h5>

        <?php $count = 0; ?>
        @foreach ($datos as $item)
            <br>
            </br>
            <table id="inv">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Fecha devuelto</th>
                        <th>Propietario</th>
                        <th>Proyecto</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach ($item->detalle as $al)
                            <tr>
                                <td>{{$al->fecha}}</td>
                                <td>{{$al->fecha_devuelto}}</td>
                                <td>{{$al->propietario}}</td>
                                <td>{{$al->proyecto}}</td>
                            </tr>
                        @endforeach    
                    </tbody>
            </table>
            <br>
            <?php $count++; ?>
        @endforeach
        <hr>
        <label>Total de Alquileres en el periodo:</label>&nbsp; <strong><br>{{$count}}
    </div>
    </br>
</body>
</html>