<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TakedExamResource extends JsonResource
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
            'answers' => $this->answers,
            // 'answers' => $this->answers->map(function ($answer) {
            //     if ($this->excercise->type === "Multiple Choice") {
            //         return [
            //             'id' => $this->id,
            //             'excercise_id' => $this->excercise_id,
            //             'question' => $this->question->question,
            //             'correct_answer' => $this->question->multiple_choice->correct_answer,
            //             'options' => $this->question->multiple_choice->getShuffledOptionsAttribute(),
            //         ];
            //     } elseif ($this->excercise->type === "True or False") {
            //         return [
            //             'id' => $this->id,
            //             'excercise_id' => $this->excercise_id,
            //             'question' => $this->question->question,
            //             'correct_answer' => $this->question->true_or_false->correct_answer,
            //         ];
            //     } elseif ($this->excercise->type === "Fill in the Blank") {
            //         return [
            //             'id' => $this->id,
            //             'excercise_id' => $this->excercise_id,
            //             'question' => $this->question->question,
            //             'correct_answer' => $this->question->fill_in_the_blank->correct_answer,
            //         ];
            //     } else {
            //         return [];
            //     }
            // }),
            'created_at' => Carbon::parse($this->created_at)->format('F j, Y g:i A'),
            'updated_at' => Carbon::parse($this->updated_at)->format('F j, Y g:i A'),
        ];
    }
}
