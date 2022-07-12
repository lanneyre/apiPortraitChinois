<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Reponse;
use App\Models\Portrait;
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
            'nom' => 'required|max:255|min:1',
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
            'nom' => 'required|max:255|min:1',
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

    /**
     * Store a newly created question with reponse(s) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function questionWithReponses(Request $request)
    {
        //dump($request->all());

        //exemple de format de données à envoyer vers l'API : 
            /*
{
    "nom": "Quel est l'âge du capitaine ?",
    "description": "Le même que celui de Sylvie",
    "image": null,
    "reponses": [
        {
            "nom": "42",
            "description": "Oui si je veux",
            "image": null,
            "point": 1
        },
        {
            "nom": "-45",
            "description": "et pourquoi pas",
            "image": null,
            "point": 2
        },
        {
            "nom": "2222",
            "description": "null",
            "image": null,
            "point": 3
        }
    ]
}
            */

        $validator = Validator::make($request->all(), [
            'nom' => 'required|max:255|min:3',
            'description' => '',
            'image' => '',
            'reponses' => 'required|array'
        ]);
        $msg = "";
        if ($validator->fails()) {
            $msg .= "Donne moi des données correctes pour la question. ";
            //    
        }

        $questionValidated = $validator->validated();

        $question = Question::create($questionValidated);
    
        foreach ($questionValidated['reponses'] as $reponse) {
            //dump($reponse);
            $validatorReponses = Validator::make($reponse, [
                'nom' => 'required|max:255|min:1',
                'description' => 'required|min:3',
                'point' => 'integer|min:1',
                'image' => '',
                'question_id' => ''
            ]);
            if ($validatorReponses->fails()) {
                $msg .= "Donne moi des données valides pour les réponses. ";
            }

            $reponsesValidated = $validatorReponses->validated();
            $reponsesValidated['question_id'] = $question->id;
            Reponse::create($reponsesValidated);
        }

        if(empty($msg)){
            $question = Question::where('id', $question->id)->with("reponses")->first();      
            return response()->json($question);
        } else {
            return response()->json(["msg" => $msg]);
        }
        
    }


    /**
     * Store a newly created question with reponse(s) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function questionToPortrait(Question $question, Portrait $portrait)
    {
        if($portrait->questions()->sync($question)){
            return response()->json(["msg" => "Association ok"]);
        } else {
            return response()->json(["msg" => "Association ko"]);
        }
    }
    public function delQuestionToPortrait(Question $question, Portrait $portrait)
    {
        if($portrait->questions()->detach($question)){
            return response()->json(["msg" => "Association enlevée"]);
        } else {
            return response()->json(["msg" => "Association impossible à enlever"]);
        }
    }
}
