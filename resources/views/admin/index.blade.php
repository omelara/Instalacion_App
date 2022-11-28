@extends('adminlte::page')

@section('title', 'PANEL DE ADMINISTRACIÓN ')

@section('content_header')

<center><h2>PANEL DE ADMINISTRACIÓN</h2></center>

 
@stop

@section('content')
    
    @section('content_header')

@stop

    <p>
        <br>
        <div class="https://twitter.com/intent/tweet?text= text-center">
        <a href="https://twitter.com/intent/tweet?text=" target="_blank"></a>
        <a href="https://twitter.com/intent/tweet?text=">
             <img src="/img/twiter.png" width="200" height="150">
        </a>
        </br>
        

        <br>
        <div class="https://www.facebook.com/sharer/sharer.php?u= text-center">
        <a href="https://www.facebook.com/sharer/sharer.php?u=" target="_blank"></a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=">
             <img src="/img/facebook.png" width="200" height="150" class="text-light mb-0 p-3 fs-7">
        </a>
        </br>


        <br>
        <div class="mailto text-center ">
        <a href="mailto:?" target="_blank"></a>
        <a href="mailto:?">
             <img src="/img/correo.jpg" width="200" height="150" class="text-light mb-0 p-4 fs-9px">
        </a>
        </br>
    </p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
@stop

@section('js')
   {{--<script> console.log('Hi!'); </script>--}}
   <script src="{{asset('js/app.js')}}"></script>
@stop



