@extends('adminlte::page')

@section('title', 'Grafico de Prestamos')

@section('content_header')
    <h1>Grafico de lineas de prestamos</h1>
@stop

@section('content')
    <div id="app">
        <div id="chart-container"></div>
    </div>
    
@stop

@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
@stop

@section('js')
    <!-- <script> console.log('Hi!'); </script> -->
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
        <script>
            var dats = <?php echo json_encode($datas) ?>

                Highcharts.chart('chart-container',{
                    title: {
                        text: 'Prestamo de equipos, 2022'
                    },
                    subtitle: {
                        text: 'Fuente: tg.net'
                    },
                    xAxis: {
                        categories: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']
                    },
                    yAxis: {
                        title: {
                            text: 'Numero de Prestamos'
                        }    
                    
                    },
                    legend: {
                        layout: 'vertical',
                        align:'right',
                        verticalAlign: 'middle'
                    },
                    plotOptions: {
                        series:{
                            allowPointSelect: true
                        }
                    },
                    series:[{
                        name:'2022',
                        data:dats
                    }],
                    responsive:{
                        rules:[
                            {
                                condition:{
                                    maxwidth:500
                                },
                                chartOptions:{
                                    legend:{
                                        layout:'horizontal',
                                        align:'center',
                                        verticalAlign:'bottom'
                                    }
                                }
                            }
                        ]
                    }
                })
                    console.log(dats);
        </script>
@stop
