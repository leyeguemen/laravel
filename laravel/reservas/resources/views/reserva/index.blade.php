@extends('reserva.layout')
@section('content')

<div class="container-fluid">

    <div class="col-sm-12" >
      <h1 class="text-center">Reservas</h1>
      <a class="btn btn-info" href="{{route('reserva.create')}}">Crear Reserva</a>
    </div>

  @if (Session::has('message'))
    <div class="clear-fix" ></div>
    <br/>
    <div class="alert alert-success alert-dismissible fade in" role="alert"> 
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span></button> 
      <strong>Success!</strong> {{ Session::get('message') }} </div>
  @endif

  <div class="col-sm-12" >
    <div class="clear-fix" ></div>
    <br/>
  </div>

  <div class="col-sm-12" >
  <div class="panel panel-info">
      <div class="panel-heading">LISTADO DE RESERVAS</div>
      <div class="panel-body"><table class="table table-bordered table-sm">
          <thead class="black white-text">
            <tr>
              <th class="col-sm-3 text-center">Nombre Usuario</th>
              <th class="col-sm-3 text-center">Apellido Usuario</th>
              <th class="col-sm-2 text-center">Fecha Reserva</th>
              <th class="col-sm-1 text-center">Fila</th>
              <th class="col-sm-1 text-center">Columna</th>
              <th class="col-sm-2 text-center">Opciones</th>
            </tr>
          </thead>
          <tbody>
              @foreach($reservas as $reserva)
            <tr>
              <td>{{$reserva->nombre_usuario}}</td>
              <td>{{$reserva->apellido_usuario}}</td>
              <td class="text-center">{{$reserva->fecha_reserva}}</td>
              <td>{{$reserva->fila_butaca}}</td>
              <td>{{$reserva->columna_butaca}}</td>
              <td>
                <div class="col-sm-6">
                  <a class="btn btn-success" href="{{route('reserva.edit', $reserva->id)}}">Editar</a>
                </div>
                <div class="col-sm-6">
                  <form action="{{ route('reserva.destroy', $reserva->id) }}" method="POST" >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                  </form>
                </div>
      
              </td>
            </tr>
            @endForeach
          </tbody>
        </table>
        {{$reservas->links()}}
        </div>
    </div>

    
    
</div>

</div>

@endSection