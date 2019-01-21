<?php

namespace App\Http\Controllers;

use App\Reservas;
use Illuminate\Http\Request;
use Session;

class ReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservas = Reservas::paginate(3);// pagina los datos de 3 en 3
        return view('reserva.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reserva.create');
    }

    /**
     * Store a newly created resource in storage.
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

        Reservas::create($request->all());

        Session::flash('message', 'Reserva guardada correctamente');

        return redirect()->route('reserva.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservas  $reservas
     * @return \Illuminate\Http\Response
     */
    public function show(Reservas $reservas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservas  $reservas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reserva = Reservas::find($id);

        return view('reserva.edit', compact('reserva'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservas  $reservas
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

        Reservas::whereId($id)->update(request()->except(['_token', '_method']));

        //Reservas::update($request->all());

        Session::flash('message', 'Reserva actualizada correctamente');

        return redirect()->route('reserva.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservas  $reservas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservas $reservas)
    {
        //
    }
}
