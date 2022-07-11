<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use HasFactory;
    protected $fillable = ["nom", "description", "image", "portraits_id"];

    public function portrait(){
        return $this->hasOne(Portrait::class);
    }
}
