@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card text-center" style="background-color:blue">
                <div class="card text-center" style="background-color:primary"> 
                <div class="card-header text-center" style="background-color:black"> 
                <div class="card-header"><h1 class="text-white">{{ __('Solicita Tu Préstamo De Equipo') }}</h1></div>

                <div class="card-body">
                 <div class="card-body text-center" style="background-color:#34495E">
                 <div class="card-header text-center" style="background-color:#eee7e7"> 
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <h2>Has clic  en el link </h2>
                    <a class="btn btn-link" href="{{ ('http://127.0.0.1:8000') }}">
                    
                    <div class="copy-right text-center" style="background-color:black">
                    <p>&copy; <div  style="background-color:white"><h2>solicitudprestamoshttp://127.0.0.1:8000 </h2></p>
             </footer> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

