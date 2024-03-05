<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MultipleChoice extends Model
{
    use HasFactory;

    protected $casts = [
        'options' => 'json', // Assuming you're using JSON to store options
    ];
    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function getOptionsWithAnswer()
    {
        $options = $this->options;
        $options[] = $this->correct_answer;
        return Arr::flatten($options);
    }

    public function getShuffledOptionsAttribute()
    {
        $options = $this->options;
        $options[] = $this->correct_answer;
        shuffle($options);


        return Arr::flatten($options);
    }
    public function getCorrectAnswer()
    {
        return $this->correct_answer;


    }
}
