<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewScoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            'feed' => $this->feed,
            'exercise_name' => $this->excercise->title,
            'exercise_type' => $this->excercise->type,
            'exercise_description' => $this->excercise->description,
            'student_name' => $this->student->user->getFullName(),
            'total_questions' => $this->getTotalExerciseQuestions(),
            'total_score' => $this->getRealScore(),
            'total_mistake' => $this->getTotalWrongAnswer(),
            'created_at' => Carbon::parse($this->created_at)->format('F j, Y g:i A'),
            'updated_at' => Carbon::parse($this->updated_at)->format('F j, Y g:i A'),
            'answers' => $this->answers->map(function($answer){
                if ($this->excercise->type === "Multiple Choice") {
                    return [
                        'exercise_type' => $this->excercise->type,
                        "id"=>  $answer->id,
                        "taked_exam_id"=> $answer->taked_exam_id,
                        "question_id"=>  $answer->question_id,
                        "question_number"=>  $answer->question->getNumber(),
                        "answer"=> $answer->answer,
                        'created_at' => Carbon::parse($this->created_at)->format('F j, Y g:i A'),
                        'updated_at' => Carbon::parse($this->updated_at)->format('F j, Y g:i A'),
                        'question'=> [
                            'id' => $answer->question->id,
                            'question' => $answer->question->question,
                            'created_at' => Carbon::parse($answer->question->created_at)->format('F j, Y g:i A'),
                            'updated_at' => Carbon::parse($answer->question->updated_at)->format('F j, Y g:i A'),
                            'correct_answer' => $answer->question->multiple_choice->correct_answer,
                            'options' => $answer->question->multiple_choice->getShuffledOptionsAttribute(),
                            // Include other question details as needed
                        ],

                    ];
                }
                elseif ($this->excercise->type === "True or False") {
                    return [
                        'exercise_type' => $this->excercise->type,
                        "id"=>  $answer->id,
                        "taked_exam_id"=> $answer->taked_exam_id,
                        "question_id"=>  $answer->question_id,
                        "question_number"=>  $answer->question->getNumber(),
                        "answer"=> $answer->answer,
                        'created_at' => Carbon::parse($this->created_at)->format('F j, Y g:i A'),
                        'updated_at' => Carbon::parse($this->updated_at)->format('F j, Y g:i A'),
                        'question'=> [
                            'id' => $answer->question->id,
                            'question' => $answer->question->question,
                            'created_at' => Carbon::parse($answer->question->created_at)->format('F j, Y g:i A'),
                            'updated_at' => Carbon::parse($answer->question->updated_at)->format('F j, Y g:i A'),
                            'correct_answer' => $answer->question->true_or_false->getTextAnswer(),
                            // Include other question details as needed
                        ],

                    ];
                }

                elseif ($this->excercise->type === "Fill in the Blank") {
                    return [
                        'exercise_type' => $this->excercise->type,
                        "id"=>  $answer->id,
                        "taked_exam_id"=> $answer->taked_exam_id,
                        "question_id"=>  $answer->question_id,
                        "question_number"=>  $answer->question->getNumber(),
                        "answer"=> $answer->answer,
                        'created_at' => Carbon::parse($this->created_at)->format('F j, Y g:i A'),
                        'updated_at' => Carbon::parse($this->updated_at)->format('F j, Y g:i A'),
                        'question'=> [
                            'id' => $answer->question->id,
                            'question' => $answer->question->question,
                            'created_at' => Carbon::parse($answer->question->created_at)->format('F j, Y g:i A'),
                            'updated_at' => Carbon::parse($answer->question->updated_at)->format('F j, Y g:i A'),
                            'correct_answer' => $answer->question->fill_in_the_blank->correct_answer,
                            // Include other question details as needed
                        ],

                    ];
                }else{
                    return [];
                }


            }),


        ];
    }
}
