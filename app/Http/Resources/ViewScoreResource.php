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
            'exercise_name' => $this->excercise->title,
            'exercise_type' => $this->excercise->type,
            'student_name' => $this->student->user->getFullName(),
            'total_questions' => $this->getTotalExerciseQuestions(),
            'total_score' => $this->getRealScore(),
            'total_mistake' => $this->getTotalWrongAnswer(),
            // 'questions_that_has_wrong_answers' =>   $this->getListOfWrongQuestions(),
            'answers'=> $this->answers,
            // 'questions_that_has_correct_answers' => $this->getQuestionThatHasCorrectAnswers(),
            'created_at' => Carbon::parse($this->created_at)->format('F j, Y g:i A'),
            'updated_at' => Carbon::parse($this->updated_at)->format('F j, Y g:i A'),
        ];
    }
}
