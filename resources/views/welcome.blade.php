@extends('templates.master')
@section('title', 'Home Page')

@section('content')
    <h3 style="text-align:center">{{"BIC : BUREAU D'INFORMATION ET DE CREDIT"}}</h2>
    <div class="form-inline">
        <div class="col col-md-3" style="text-align:center;">
            <h3> {{"BENIN"}} </h3>
            <h3>{{"BURKINA FASSO"}} </h3>
            <h3> {{"GUINEE BISSAU"}} </h3>
        </div>
        <div class="col col-md-6" style="text-align:center">
            <img src="{{ asset('images/uemoa.jpg')}}" alt="" style="width:280px">
        </div>
        <div class="col col-md-3" style="text-align:left">
            <h3>{{"NIGER"}}</h3>
            <h3>{{"SENEGAL"}}</h3>
            <h3>{{"TOGO"}}</h3>
        </div>
    </div>
@endsection
