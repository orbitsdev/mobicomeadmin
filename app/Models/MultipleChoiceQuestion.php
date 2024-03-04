<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MultipleChoiceQuestion extends Model
{
    use HasFactory;

    protected $casts = [
        'options' => 'json', // Assuming you're using JSON to store options
    ];
    public function question(){
        return $this->belongsTo(Question::class);
    }
}
