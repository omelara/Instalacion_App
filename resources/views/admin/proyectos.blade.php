
@extends('adminlte::page')

@section('title', 'Proyectos')

@section('content_header')
    <center>
        <h1>Proyectos Instalaciones Eléctricas</h1>
    </center>
@stop

@section('content')
<div id="app" class="card-body" style="background-color:#34495E">
    <v-app class="">
        <template>
            <Proyectos></Proyectos>
        </template>
    </v-app>
</div>
    
@stop

@section('css')
<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet"
@stop

@section('js')
<!-- <script> console.log('Hi!'); </script> -->
   <script src="{{asset('js/app.js')}}"></script>

@stop
