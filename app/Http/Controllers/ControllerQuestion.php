<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControllerQuestion extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Question::all());
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
            'description' => '',
            'image' => ''
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();
        if(Question::create($validated)){
            return response()->json(["msg" => "Question créé avec succè"]);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
        $question = Question::where('id', $question->id)->with("reponses")->first();
        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
        $validator = Validator::make($request->all(), [
            'nom' => 'required|max:255|min:3',
            'description' => '',
            'image' => ''
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();

        $question->nom = $validated->nom;
        $question->description = $validated->description;
        $question->image = $validated->image;

        if($question->save()){
            return response()->json($question);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        foreach($question->reponses as $reponse){
            $reponse->delete();
        }
        if($question->delete()){
            return response()->json(["msg" => "suppr ok"]);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }
}
