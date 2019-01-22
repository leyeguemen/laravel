<?php

namespace App\Http\Controllers;

use App\Reservas;
use Illuminate\Http\Request;
use Session;
use Storage;

class ReservasController extends Controller
{
    /**
     * Muestra la lista de reservas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservas = Reservas::paginate(3);// pagina los datos de 3 en 3
        return view('reserva.index', compact('reservas'));
    }

    /**
     * Muestra el formulario para crear una nueva reserva.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reserva.create');
    }

    /**
     * Guardar en la base de datos la reserva.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_usuario' => 'required',
            'apellido_usuario' => 'required',
            'fecha_reserva' => 'required',
            'numero_personas' => 'required',
            'fila_butaca' => 'required',
            'columna_butaca' => 'required'
        ]);

        // ------------------------------------------------
        // VALIDAR LA DISPONIBLIDAD DE LA BUTACA
        // ------------------------------------------------

        // DATOS DEL FORMULARIO
        $fechaReserva = $request->input('fecha_reserva');
        $fila = $request->input('fila_butaca');
        $columna = $request->input('columna_butaca');
        $nombreUsuario = $request->input('nombre_usuario');
        $apellidoUsuario = $request->input('apellido_usuario');
        $numeroPersonas = $request->input('numero_personas');

        $reservas = Reservas::all();
        $encontroFila = false;
        $encontroColumna = false;

        // BUSCAR LA FILA EN LA MISMA FECHA
		foreach ($reservas as $reserva) {
            if($reserva->fila_butaca == $fila && $reserva->fecha_reserva == $fechaReserva){
                $encontroFila = true;
                break;
            }
        }

        // BUSCAR LA COLUMNA EN LA MISMA FECHA
		foreach ($reservas as $reserva) {
            if($reserva->columna_butaca == $columna && $reserva->fecha_reserva == $fechaReserva){
                $encontroColumna = true;
                break;
            }
        }

        if($encontroFila == true && $encontroColumna == true){
            Session::flash('messageerror', 'La butaca, para el dia '. $fechaReserva .' en la fila:' . $fila . ' y columa:'. (int)$columna . ' Ya se encuentra ocupada.');
            return redirect()->route('reserva.create');
        }

        // ------------------------------------------------
        // FIN VALIDAR LA DISPONIBLIDAD DE LA BUTACA
        // ------------------------------------------------

        // ENVIAR A GUARDAR TODA LA RESERVA
        Reservas::create($request->all());

        // ------------------------------------------------
        // ARCHIVO LOG
        // ------------------------------------------------
        $archivoLog = 'log.txt';
        $exists = Storage::exists($archivoLog);
        
        $fechaReserva = $request->input('fecha_reserva');
        $fila = $request->input('fila_butaca');
        $columna = $request->input('columna_butaca');
        $nombreUsuario = $request->input('nombre_usuario');
        $apellidoUsuario = $request->input('apellido_usuario');
        $numeroPersonas = $request->input('numero_personas');

        $log = 
        'nombre_usuario => ' . $nombreUsuario. 
        ',apellido_usuario => '.$apellidoUsuario.
        ',fecha_reserva => '.$fechaReserva.
        ',numero_personas => '.$numeroPersonas.
        ',fila_butaca => '.$fila.
        ',columna_butaca => '.$columna.
        ',accion => CREATE';       
        
        if($exists){// SI EXISTE ESCRIBIR EL REGISTRO
            Storage::append($archivoLog, $log);   
        }else{// NO EXISTE SE DEBE CREAR EL ARCHIVO Y ESCRIBIR EL REGISTRO
            Storage::put($archivoLog, $log);
        }
        // ------------------------------------------------
        // FIN ARCHIVO LOG
        // ------------------------------------------------

        // MOSTRAR MENSAJE
        Session::flash('message', 'Reserva guardada correctamente');

        return redirect()->route('reserva.index');
    }

    /**
     * Muestra el formulario con los datos de la reserva para editar.
     *
     * @param  $id: identificador de la reserva
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reserva = Reservas::find($id);

        return view('reserva.edit', compact('reserva'));
    }

    /**
     * Actualiza una reserva especifica en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id: identificador de la reserva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_usuario' => 'required',
            'apellido_usuario' => 'required',
            'fecha_reserva' => 'required',
            'numero_personas' => 'required',
            'fila_butaca' => 'required',
            'columna_butaca' => 'required'
        ]);

        // ------------------------------------------------
        // VALIDAR LA DISPONIBLIDAD DE LA BUTACA
        // ------------------------------------------------
        $fechaReserva = $request->input('fecha_reserva');
        $fila = $request->input('fila_butaca');
        $columna = $request->input('columna_butaca');
    
        $reservas = Reservas::all();
        $encontroFila = false;
        $encontroColumna = false;

        // BUSCAR LA FILA EN LA MISMA FECHA
		foreach ($reservas as $reserva) {
            if($reserva->fila_butaca == $fila && $reserva->fecha_reserva == $fechaReserva && $reserva->id != $id){
                $encontroFila = true;
                break;
            }
        }

        // BUSCAR LA COLUMNA EN LA MISMA FECHA
		foreach ($reservas as $reserva) {
            if($reserva->columna_butaca == $columna && $reserva->fecha_reserva == $fechaReserva && $reserva->id != $id){
                $encontroColumna = true;
                break;
            }
        }

        if($encontroFila == true && $encontroColumna == true){
            Session::flash('messageerror', 'La butaca, para el dia '. $fechaReserva .' en la fila:' . $fila . ' y columa:'. (int)$columna . ' Ya se encuentra ocupada.');
            
            $reserva = Reservas::find($id);
            return view('reserva.edit', compact('reserva'));
        }

        // ------------------------------------------------
        // FIN VALIDAR LA DISPONIBLIDAD DE LA BUTACA
        // ------------------------------------------------

        Reservas::whereId($id)->update(request()->except(['_token', '_method']));

        // ------------------------------------------------
        // ARCHIVO LOG
        // ------------------------------------------------
        $archivoLog = 'log.txt';
        $exists = Storage::exists($archivoLog);
        
        $fechaReserva = $request->input('fecha_reserva');
        $fila = $request->input('fila_butaca');
        $columna = $request->input('columna_butaca');
        $nombreUsuario = $request->input('nombre_usuario');
        $apellidoUsuario = $request->input('apellido_usuario');
        $numeroPersonas = $request->input('numero_personas');

        $log = 
        'nombre_usuario => ' . $nombreUsuario. 
        ',apellido_usuario => '.$apellidoUsuario.
        ',fecha_reserva => '.$fechaReserva.
        ',numero_personas => '.$numeroPersonas.
        ',fila_butaca => '.$fila.
        ',columna_butaca => '.$columna.
        ',accion => UPDATE';       
        
        if($exists){// SI EXISTE ESCRIBIR EL REGISTRO
            Storage::append($archivoLog, $log);   
        }else{// NO EXISTE SE DEBE CREAR EL ARCHIVO Y ESCRIBIR EL REGISTRO
            Storage::put($archivoLog, $log);
        }
        // ------------------------------------------------
        // FIN ARCHIVO LOG
        // ------------------------------------------------

        Session::flash('message', 'Reserva actualizada correctamente');

        return redirect()->route('reserva.index');
    }

    /**
     * Eliminar una reserva especifica de la base de datos..
     *
     * @param  $id: identificador de la reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Reservas::whereId($id)->delete();
        Session::flash('message','La reserva ha sido borrada  correctamente');
        return redirect()->route('reserva.index');
    }
}
