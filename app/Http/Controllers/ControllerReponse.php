<?php

namespace App\Http\Controllers;

use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControllerReponse extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(Reponse::all());
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
            'nom' => 'required|max:255|min:3',
            'description' => 'required|min:10',
            'image' => '',
            'point' => 'integer|min:1',
            'question_id' => 'integer|min:1'
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();
        if(Reponse::create($validated)){
            return response()->json(["msg" => "Réponse créé avec succè"]);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reponse  $reponse
     * @return \Illuminate\Http\Response
     */
    public function show(Reponse $reponse)
    {
        //
        $reponse = Reponse::Where("id", $reponse->id)->with("questions")->first();
        return response()->json($reponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reponse  $reponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reponse $reponse)
    {
        //
        $validator = Validator::make($request->all(), [
            'nom' => 'required|unique:portraits|max:255|min:3',
            'description' => 'required|min:10',
            'image' => '',
            'point' => 'integer|min:1',
            'question_id' => 'integer|min:1'
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();

        $reponse->nom = $validated->nom;
        $reponse->description = $validated->description;
        $reponse->image = $validated->image;
        $reponse->point = $validated->point;
        $reponse->question_id = $validated->question_id;

        if($reponse->save()){
            return response()->json($reponse);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reponse  $reponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reponse $reponse)
    {
        return response()->json(["msg" => $reponse->delete()]);
    }

    public function reponseWithQuestion(Reponse $reponse){
        $question = $reponse->question;
        return response()->json($question);
    }
}
