<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Excercise;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exact;
use App\Http\Resources\ModelResource;
use App\Models\Question;
use Illuminate\Validation\ValidationException;

class ExercisesController extends Controller
{


    public function getExerciseQuestions(Request $request){

        $exercise = Excercise::find($request->exercise_id);


        $questions = Question::where('exercise_id', $request->exercise_id);




        switch($exercise->type){
            case 'Multiple Choice':
            break;
            case 'Fill in the Blank':
            break;
            case 'True or False':
            break;

        }

        return response()->apiResponse([
            'data' => [
                "id" => $exercise->id,
                "title" => $exercise->title,
                "description" => $exercise->description,
                "type" => $exercise->type,
                "total_questions" => $exercise->getTotalQuestions(),
                'created_at' => $exercise->created_at->format('F j, Y g:i A'),
                'updated_at' => $exercise->updated_at->format('F j, Y g:i A'),
            ],
        ]);

    }

    public function take(Request $request)
{
    try {
        // Find the student
        $student = Student::find($request->student_id);
        if (!$student) {
            return response()->apiResponse('Student not found', 404, false);
        }

        // Find the exercise
        $exercise = Excercise::find($request->exercise_id);
        if (!$exercise) {
            return response()->apiResponse('Exercise not found', 404, false);
        }

        // Create a new TakedExam for the student
        $taked_exam = $student->taked_exam()->create([
            'excercise_id' => $exercise->id,
        ]);

        return response()->apiResponse([
            'data' => $taked_exam,
        ]);
    } catch (ValidationException $e) {
        return response()->apiResponse($e->errors(), 200, false);
    }
}




    public function getExercises(Request $request)
    {
        try {




            $collection = Excercise::all();

            // Map lessons to desired format
            $new_collection = $collection->map(function($item) {
                return [
                    "id" => $item->id,
                    "title" => $item->title,
                    "description" => $item->description,
                    "type" => $item->type,
                    "total_questions" => $item->getTotalQuestions(),
                    'created_at' => $item->created_at->format('F j, Y g:i A'),
                    'updated_at' => $item->updated_at->format('F j, Y g:i A'),

                ];
            });

            return response()->apiResponse([
                'data' => ModelResource::collection($new_collection),
            ]);
        } catch (ValidationException $e) {
            return response()->apiResponse($e->errors(), 200, false);
        }
    }

    public function getQuestions(Request $request)
    {
        try {



            // $collection = Excercise::all();

            // // Map lessons to desired format
            // $new_collection = $collection->map(function($item) {
            //     return [
            //         "id" => $item->id,
            //         "title" => $item->title,
            //         "description" => $item->description,
            //         "type" => $item->type,
            //         "total_questions" => $item->getTotalQuestions(),
            //         'created_at' => $item->created_at->format('F j, Y g:i A'),
            //         'updated_at' => $item->updated_at->format('F j, Y g:i A'),

            //     ];
            // });

            return response()->apiResponse([
                'data' => ModelResource::collection($request->all()),
            ]);
        } catch (ValidationException $e) {
            return response()->apiResponse($e->errors(), 200, false);
        }
    }



}
