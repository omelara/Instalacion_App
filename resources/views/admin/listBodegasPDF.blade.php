<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles_pdf.css">
    <title>bodegasPDF</title>
   
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div><img class="logo fl-left" src="img/icono.png" alt=""></div>
            <h3 class="title">Instalacion de sistemas Electricos</h3>
            <div class="clear"></div>
        </div>
    </header>
    <h1 class="report-title">Reporte de bodegas</h1>
    <table class="table" border="1px">
        <thead>
            <th>Cantidad</th>
            <th class="desc">Descripcion</th>
            <th>Codigo</th>
            <th>Equipo</th>
            <th>Marca</th>
            @foreach($bodegas as $bodega)
                <tr>
                    <td><?=$bodega->cantidad?></td>
                    <td><?=$bodega->descripcion?></td>
                    <td><?=$bodega->codigo?></td>
                    <td><?=$bodega->equipo?></td>
                    <td><?=$bodega->marca?></td>
                </tr>
            @endforeach
        </thead>
    </table>

    <span class="pageNumber">Pagina 1</span>
    <div class="page-break"></div>
    <span class="pageNumber">Pagina 2</span>
    <div class="page-break"></div>


    <footer>
      <v-app class="bg-black">
    </footer>


</body>
</html>