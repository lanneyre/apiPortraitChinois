<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portrait extends Model
{
    use HasFactory;

    protected $fillable = ["nom", "description", "image"];
    
    //permet de récupérer les questions associées au portrait
    public function questions(){
        return $this->belongsToMany(Question::class);
    }

    public function resultats(){
        return $this->hasMany(Resultat::class);
    } 
}
