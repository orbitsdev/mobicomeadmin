<?php

namespace App\Models;

use App\Models\Feed;
use App\Models\Answer;
use App\Models\Student;
use App\Models\Excercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class TakedExam extends Model
{
    use HasFactory;


    public function excercise(){
        return $this->belongsTo(Excercise::class);
    }
    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function getRealScore()
{
    $totalScore = 0;

    foreach ($this->answers as $answer) {
        $question = $answer->question;

        switch ($this->excercise->type) {
            case 'Multiple Choice':
                $actual_answer = $answer->question->multiple_choice->correct_answer;
                break;
            case 'Fill in the Blank':
                $actual_answer = $answer->question->fill_in_the_blank->correct_answer;
                break;
            case 'True or False':
                $actual_answer = $answer->question->true_or_false->correct_answer;
                break;
            // Handle unsupported question types
        }

        // Compare the submitted answer with the correct answer using the compareUserAnswer method
        $result = $answer->compareUserAnswer($actual_answer, $this->excercise->type);

        // Increment the total score if the answer is correct
        if ($result === 'Correct') {
            $totalScore++;
        }
    }

    return $totalScore;
}

    
    

    public function getTotalScore()
    {
        return $this->answers->where('status', true)->count();
    }
    public function getTotalWrongScore()
    {
        return $this->answers->where('status', false)->count();
    }
    public function getQuestionThatHasWrongAnswers()
    {
        return $this->excercise->questions()
            ->whereHas('answers', function ($query) {
                $query->where('status', false);
            })
            ->get()->map(function($item){
                return [
                    "id" => $item->id,
                    "excercise_id"=> $item->excercise_id,
                    "question"=> $item->question,
                    "description"=> $item->description,
                    "question_number_id"=> $item->question_number_id,
                    'created_at' => Carbon::parse($this->created_at)->format('F j, Y g:i A'),
                    'updated_at' => Carbon::parse($this->updated_at)->format('F j, Y g:i A'),
                    // 'answer' => $item->getAnswerBaseOnType(),
                    // 'correct_answer'=> $item->getCorrectAnswer(),
                    
                ];
            });
    }
    
    public function getQuestionThatHasCorrectAnswers()
    {
        return $this->excercise->questions()
            ->whereHas('answers', function ($query) {
                $query->where('status', true);
            })
            ->get();
    }
    
    public function getTotalExerciseQuestions()
    {
        return $this->excercise->questions()->count();
    }


    public function feed(){
        return $this->hasOne(Feed::class);
    }

}
