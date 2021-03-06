<?php

namespace App\Http\Controllers;

use App\Models\Portrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ControllerPortraitWeb extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portraits = Portrait::all();
        return view('portrait.index', ["portraits"=>$portraits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $portraits = Portrait::all();
        return view('portrait.create', ["portraits"=>$portraits]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $messages = [
			'nom.max' => 'Le nom du portrait ne peut avoir plus de :max caractères.',
            'nom.max' => 'Le nom du portrait existe déjà.',
            'nom.min' => 'Le nom du portrait ne peut avoir moins de :min caractères.',
			'nom.required' => 'Vous devez saisir un nom pour le portrait.',
			'description.min' => 'La description du portrait ne peut avoir moins de :min caractères.',
			'description.required' => 'Vous devez saisir la description.',
			'imageOrdi.image' => 'Le fichier doit être une image.',
			'imageUrl.regex' => 'L\'url de l\'image n\'est pas bonne.',

		];
        $validator = Validator::make($request->all(), [
            'nom' => 'required|unique:portraits|max:255|min:3',
            'description' => 'required|min:10',
            'imageOrdi' => 'image|nullable',
            'imageUrl' => 'nullable|regex:'.$regex
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $validated = $validator->validated();
        $validated['image'] = $validated['imageUrl'];
        if ($request->hasFile('imageOrdi')) {
            $nameFile = uniqid().".".$request->imageOrdi->extension();
            $path = $request->imageOrdi->storeAs('public/img', $nameFile);
            $url = url("/")."/".str_replace("public", "storage", $path);
            $validated['image'] = $url;
        }

        if(Portrait::create($validated)){
            return redirect()->route('portrait.index')->with(["success" => "Création OK"]);
        } else {
            return redirect()->back()->withErrors(["erreur Creation"]);
        }
        return redirect()->back();
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
        return view('portrait.show', ["portrait"=>$portrait, "portraits"=>Portrait::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portrait  $portrait
     * @return \Illuminate\Http\Response
     */
    public function edit(Portrait $portrait)
    {
        //
        $portrait = Portrait::where('id', $portrait->id)->with(["questions", "resultats"])->first();
        return view('portrait.edit', ["portrait"=>$portrait, "portraits"=>Portrait::all()]);
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
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $messages = [
			'nom.max' => 'Le nom du portrait ne peut avoir plus de :max caractères.',
            'nom.min' => 'Le nom du portrait ne peut avoir moins de :min caractères.',
			'nom.required' => 'Vous devez saisir un nom pour le portrait.',
			'description.min' => 'La description du portrait ne peut avoir moins de :min caractères.',
			'description.required' => 'Vous devez saisir la description.',
			'imageOrdi.image' => 'Le fichier doit être une image.',
			'imageUrl.regex' => 'L\'url de l\'image n\'est pas bonne.',

		];

        $validator = Validator::make($request->all(), [
            'nom' => 'required|max:255|min:3',
            'description' => 'required|min:10',
            'imageOrdi' => 'image|nullable',
            'imageUrl' => 'nullable|regex:'.$regex
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $validated = $validator->validated();

        $portrait->nom = $validated['nom'];
        $portrait->description = $validated['description'];
        //dd($validated);
        if(!empty($validated['imageOrdi']) || !empty($validated['imageUrl'])){
            if(!empty($portrait->image)){
                $path = str_replace(url("/"), "", $portrait->image);
                //dump($path);
                if($path != $portrait->image){
                    Storage::delete(str_replace("storage", "public", $path));
                }
            }
            $validated['image'] = $validated['imageUrl'];
            if ($request->hasFile('imageOrdi')) {
                $nameFile = uniqid().".".$request->imageOrdi->extension();
                $path = $request->imageOrdi->storeAs('public/img', $nameFile);
                $url = url("/")."/".str_replace("public", "storage", $path);
                $validated['image'] = $url;
            }
            $portrait->image = $validated['image'];
        }
        //

        if($portrait->save()){
            return redirect()->back()->with(["success" => "edit OK"]);
        } else {
            return redirect()->back()->with(["error"=>"erreur Edition"]);
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
        if(!empty($portrait->image)){
            $path = str_replace(url("/"), "", $portrait->image);
            //dump($path);
            if($path != $portrait->image){
                Storage::delete(str_replace("storage", "public", $path));
            }
        }

        if($portrait->delete()){
            return redirect()->route('portrait.index')->with(["success" => "suppr OK"]);
        } else {
            return redirect()->back()->with(["error"=>"erreur suppr"]);
        }
    }
}
