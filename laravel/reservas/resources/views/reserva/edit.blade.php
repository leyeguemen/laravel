@extends('reserva.layout')
@section('content')

<div class="container">
    <h1 class="text-center">Editar Reserva</h1>

    @if (Session::has('message'))
        <div class="clear-fix" ></div>
        <br/>
        <div class="alert alert-success alert-dismissible fade in" role="alert"> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span></button> 
        <strong>Success!</strong> {{ Session::get('message') }} </div>
    @endif

    <form action="{{ route('reserva.update', $reserva->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="panel panel-primary">
            <div class="panel-heading">Datos Usuario</div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <div class="form-group">
                        <strong>Nombres usuario:</strong>
                        <input type="text" name="nombre_usuario" value="{{$reserva->nombre_usuario}}" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <strong>Apellidos usuario:</strong>
                        <input type="text" name="apellido_usuario" value="{{$reserva->apellido_usuario}}" class="form-control" required>
                    </div>
                </div>                
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">Datos Reserva</div>
            <div class="panel-body">
            
                <div class="col-sm-6">
                    <div class="form-group">
                        <strong>Fecha reserva:</strong>
                        <input type="date" name="fecha_reserva"  value="{{$reserva->fecha_reserva}}" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <strong>Numero personas:</strong>
                        <input type="number" name="numero_personas" value="{{$reserva->numero_personas}}" class="form-control" required>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="sel1">Fila:</label>
                        <select class="form-control" name="fila_butaca" required>
                            <option value='0'>Seleccione...</option>
                            <option value='1' {{ $reserva->fila_butaca=="1" ? 'selected':''}} >1</option>
                            <option value='2' {{ $reserva->fila_butaca=="2" ? 'selected':''}} >2</option>
                            <option value='3' {{ $reserva->fila_butaca=="3" ? 'selected':''}} >3</option>
                            <option value='4' {{ $reserva->fila_butaca=="4" ? 'selected':''}} >4</option>
                            <option value='5' {{ $reserva->fila_butaca=="5" ? 'selected':''}} >5</option>
                        </select>                    
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="sel1">Columna:</label>
                        <select class="form-control" name="columna_butaca" required>
                            <option value='0'>Seleccione...</option>
                            <option value='1' {{ $reserva->columna_butaca=="1" ? 'selected':''}} >1</option>
                            <option value='2' {{ $reserva->columna_butaca=="2" ? 'selected':''}} >2</option>
                            <option value='3' {{ $reserva->columna_butaca=="3" ? 'selected':''}} >3</option>
                            <option value='4' {{ $reserva->columna_butaca=="4" ? 'selected':''}} >4</option>
                            <option value='5' {{ $reserva->columna_butaca=="5" ? 'selected':''}} >5</option>
                            <option value='6' {{ $reserva->columna_butaca=="6" ? 'selected':''}} >6</option>
                            <option value='7' {{ $reserva->columna_butaca=="7" ? 'selected':''}} >7</option>
                            <option value='8' {{ $reserva->columna_butaca=="8" ? 'selected':''}} >8</option>
                            <option value='9' {{ $reserva->columna_butaca=="9" ? 'selected':''}} >9</option>
                            <option value='10' {{ $reserva->columna_butaca=="10" ? 'selected':''}} >10</option>
                        </select>                    
                    </div>
                </div>

            </div>
        </div>
    
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-success">Guardar</button>
            <a class="btn btn-danger" href="{{route('reserva.index')}}">Cancelar</a>
        </div>
    </form>
  
</div>

@endSection