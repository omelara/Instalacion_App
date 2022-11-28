@extends('adminlte::page')

@section('title', 'Reporte ')

@section('content_header')
   <center> <h1>Reporte de Descargos</h1></center>
@stop

@section('content')
<div id="app">
    <v-app>
        <v-app>
            <template>
                 <descargo-report></descargo-report>
            </template>
        </v-app>
    </v-app>
</div>
    
@stop

@section('css')
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
@stop

@section('js')
<!-- <script> console.log('Hi!'); </script> -->
   <script src="{{asset('js/app.js')}}"></script>

@stop