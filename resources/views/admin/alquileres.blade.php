@extends('adminlte::page')

@section('title', 'Alquileres')

@section('content_header')
    <center><h1>Alquileres</h1></center>
@stop

@section('content')
<div id="app" class="card-body" style="background-color:#34495E">
    <v-app class="bg-black">
        <template>
            <Alquileres></Alquileres>
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
