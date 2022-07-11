<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;
    protected $fillable = ["nom", "description", "image", "point", 'question_id'];

    public function question(){
        return $this->hasOne(Question::class);
    }
}
