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

    // $answers =[];
    foreach ($this->answers as $answer) {
        
            $question_answer = null;    
            $actual_answer =  $answer->answer;    
         if($this->excercise->type === "Multiple Choice"){
                $question_answer =  $answer->question->multiple_choice->correct_answer;
                if(strtolower($question_answer)  == strtolower($actual_answer)){
                    $totalScore++;
                }
          }
          
         if($this->excercise->type === "True or False"){
                $question_answer =  $answer->question->true_or_false->getTextAnswer();
                if(strtolower($question_answer) == strtolower($actual_answer)){
                    $totalScore++;
                }
          }
          
         if($this->excercise->type === "Fill in the Blank"){
                $question_answer =  $answer->question->fill_in_the_blank->correct_answer;
                if(strtolower($question_answer) == strtolower($actual_answer)){
                    $totalScore++;
                }
          }

          
    
    }

    return $totalScore;
}
    public function getTotalWrongAnswer()
{

    
    $total = 0;

    // $answers =[];
    foreach ($this->answers as $answer) {
        
            $question_answer = null;    
            $actual_answer =  $answer->answer;    
         if($this->excercise->type === "Multiple Choice"){
                $question_answer =  $answer->question->multiple_choice->correct_answer;
                if(strtolower($question_answer)  != strtolower($actual_answer)){
                    $total++;
                }
          }
          
         if($this->excercise->type === "True or False"){
                $question_answer =  $answer->question->true_or_false->getTextAnswer();
                if(strtolower($question_answer) != strtolower($actual_answer)){
                    $total++;
                }
          }
          
         if($this->excercise->type === "Fill in the Blank"){
                $question_answer =  $answer->question->fill_in_the_blank->correct_answer;
                if(strtolower($question_answer) != strtolower($actual_answer)){
                    $total++;
                }
          }

          
    
    }

    return $total;
}

public function getQuestionThatHasWrongAsnwer()
{
    $wrongQuestions = [];

    // Iterate through answers and check correctness
    foreach ($this->answers as $answer) {
        $actualAnswer = $answer->answer;
        $questionAnswer = null;

        // Check exercise type and get the correct answer accordingly
        if ($this->excercise->type === "Multiple Choice") {
            $questionAnswer = $answer->question->multiple_choice->correct_answer;
        } elseif ($this->excercise->type === "True or False") {
            $questionAnswer = $answer->question->true_or_false->getTextAnswer();
        } elseif ($this->excercise->type === "Fill in the Blank") {
            $questionAnswer = $answer->question->fill_in_the_blank->correct_answer;
        } else {
            continue; // Skip if exercise type is unknown
        }

        // Check if the answer is wrong
        if (strtolower($questionAnswer) !== strtolower($actualAnswer)) {
            // Add the question to the list
            $wrongQuestions[] = $answer->question;
        }
    }

    return $wrongQuestions;
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
