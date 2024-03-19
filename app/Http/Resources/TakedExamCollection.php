<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TakedExamCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($takedExam) {
                return [
                    'id' => $this->id,
                    'exercise_name' => $this->excercise->title,
                    'exercise_type' => $this->excercise->type,
                    'student_name' => $this->student->user->getFullName(),
                    'total_questions' => $this->getTotalExerciseQuestions(),
                    'total_score' => $this->getTotalScore(),
                    'total_mistake' => $this->getTotalWrongScore(),
                    'questions_that_has_wrong_answers' =>   $this->getQuestionThatHasWrongAnswers(),
                    'questions_that_has_correct_answers' => $this->getQuestionThatHasCorrectAnswers(),
                    'created_at' => Carbon::parse($this->created_at)->format('F j, Y g:i A'),
                    'updated_at' => Carbon::parse($this->updated_at)->format('F j, Y g:i A'),
                    // Add more fields as needed
                ];
            })
        ];
    }
}
