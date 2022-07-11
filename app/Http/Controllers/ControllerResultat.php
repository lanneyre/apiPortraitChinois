<?php

namespace App\Http\Controllers;

use App\Models\Resultat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'nom' => 'required|unique:portraits|max:255|min:3',
            'description' => 'required|min:10',
            'image' => '',
            "portrait_id" => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();
        if(Resultat::create($validated)){
            return response()->json(["msg" => "Resultat créé avec succè"]);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
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
        $validator = Validator::make($request->all(), [
            'nom' => 'required|unique:portraits|max:255|min:3',
            'description' => 'required|min:10',
            'image' => '',
            "portrait_id" => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();
        

        $resultat->nom = $validated->nom;
        $resultat->description = $validated->description;
        $resultat->image = $validated->image;
        $portrait->portrait_id = $validated->nom;
        
        if($resultat->save()){
            return response()->json(["msg" => "Resultat modifié avec succè"]);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
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
        return response()->json(["msg" => $resultat->delete()]);
    }
}
