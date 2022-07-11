<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControllerUser extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(User::all());
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
            'name' => 'required|max:255|min:3',
            'email' => 'required|email',
            'password' => 'required|Confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();
        if(User::create($validated)){
            return response()->json(["msg" => "User créé avec succè"]);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:3',
            'email' => 'required|email',
            'password' => 'required|Confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json(["msg" => "Donne moi des données correctes"]);    
        }

        $validated = $validator->validated();

        $user->name = $validated->name;
        $user->email = $validated->email;
        $user->password = Hash::make($validated->password);

        if($user->save()){
            return response()->json($user);
        } else {
            return response()->json(["msg" => "Echec"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return response()->json(["msg" => $user->delete()]);
    }
}
