<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ["nom", "description", "image"];

    public function reponses(){
        return $this->hasMany(Reponse::class);
    }

    public function portraits(){
        return $this->belongsToMany(Portrait::class);
    }
}
