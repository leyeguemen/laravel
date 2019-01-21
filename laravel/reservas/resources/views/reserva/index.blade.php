@extends('reserva.layout')
@section('content')

<div class="container-fluid">
  <h1 class="text-center">Reservas</h1>
  <a class="btn btn-info" href="{{route('reserva.create')}}">Crear Reserva</a>
  
  @if (Session::has('message'))
    <div class="clear-fix" ></div>
    <br/>
    <div class="alert alert-success alert-dismissible fade in" role="alert"> 
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span></button> 
      <strong>Success!</strong> {{ Session::get('message') }} </div>
  @endif

  <div class="clear-fix" ></div>
  <br/>
    <table class="table table-condensed">
    <thead>
      <tr>
        <th>Nombre Usuario</th>
        <th>Apellido Usuario</th>
        <th>Fecha Reserva</th>
        <th>Fila</th>
        <th>Columna</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>

        @foreach($reservas as $reserva)
      <tr>
        <td>{{$reserva->nombre_usuario}}</td>
        <td>{{$reserva->apellido_usuario}}</td>
        <td>{{$reserva->fecha_reserva}}</td>
        <td>{{$reserva->fila_butaca}}</td>
        <td>{{$reserva->columna_butaca}}</td>
        <td>
          <a class="btn btn-success" href="{{route('reserva.edit', $reserva->id)}}">Editar</a>         
        </td>
      </tr>
      @endForeach
    </tbody>
  </table>
  {{$reservas->links()}}

</div>

@endSection