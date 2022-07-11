<?php

namespace App\Http\Controllers;

use App\Models\Resultat;
use Illuminate\Http\Request;

class ControllerResultat extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(Resultat::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resultat  $resultat
     * @return \Illuminate\Http\Response
     */
    public function show(Resultat $resultat)
    {
        //
        return response()->json($resultat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resultat  $resultat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resultat $resultat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resultat  $resultat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resultat $resultat)
    {
        //
    }
}
