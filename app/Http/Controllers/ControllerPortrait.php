<?php

namespace App\Http\Controllers;

use App\Models\Portrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControllerPortrait extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portraits = Portrait::with(["questions", "resultats"])->get();
        return response()->json($portraits);
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
        $validator = Validator::make($request->all(), [
            'nom' => 'required|unique:portraits|max:255|min:3',
            'description' => 'required|min:10',
            'image' => ''
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();
        if(Portrait::create($validated)){
            return response()->json(["msg" => "Portrait créé avec succè"]);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Portrait  $portrait
     * @return \Illuminate\Http\Response
     */
    public function show(Portrait $portrait)
    {
        //

        $portrait = Portrait::where('id', $portrait->id)->with(["questions", "resultats"])->first();
        return response()->json($portrait);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portrait  $portrait
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portrait $portrait)
    {
        //
        $validator = Validator::make($request->all(), [
            'nom' => 'required|unique:portraits|max:255|min:3',
            'description' => 'required|min:10',
            'image' => ''
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();

        $portrait->nom = $request->nom;
        $portrait->description = $request->description;
        $portrait->image = $request->image;

        if($portrait->save()){
            return response()->json($portrait);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portrait  $portrait
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portrait $portrait)
    {
        //
        foreach($portrait->resultats as $result){
            $result->delete();
        }
        foreach($portrait->questions as $question){
            $question->portraits()->detach();
        }
        if($portrait->delete()){
            return response()->json(["msg" => "suppr ok"]);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }
}
