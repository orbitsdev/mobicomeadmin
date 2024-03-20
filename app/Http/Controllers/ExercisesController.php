<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Student;
use App\Models\Question;
use App\Models\Excercise;
use App\Models\TakedExam;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exact;
use App\Http\Resources\ModelResource;
use App\Http\Resources\TakedExamResource;
use App\Http\Resources\ViewScoreResource;
use Illuminate\Validation\ValidationException;

class ExercisesController extends Controller
{

    public function addFeedback(Request $request)
    {


        try {

            $taked_exam = TakedExam::where('id', $request->taked_exam_id)->first();

            // Check if it doesn't have feedback yet
            if (!$taked_exam->feed) {
                $feedback = new Feed();
                $feedback->taked_exam_id = $request->taked_exam_id;
                $feedback->rate = $request->rate;
                $feedback->message = $request->message;
                $feedback->save();
                return response()->apiResponse(new ModelResource($feedback));
            } else {
                return response()->apiResponse('Feedback already exists for this taked exam.', 200, false);
            }

            return response()->json(new ModelResource($taked_exam));
        } catch (\Exception $e) {
            return response()->apiResponse($e->getMessage(), 200, false);

        }
    }

    public function viewScore(Request $request){
        try {

            $taked_exam = TakedExam::where('id', $request->taked_exam_id)->first();

            return response()->apiResponse(new ViewScoreResource($taked_exam));
        } catch (\Exception $e) {
            return response()->apiResponse([], $e->getMessage(), false, 500);
        }
    }
    public function getStudentExercises(Request $request)
    {
        try {
            $studentId = $request->input('student_id');

            // Fetch exercises for the given student
            $exercises = TakedExam::where('student_id', $studentId)->latest()->get();

            return response()->apiResponse(TakedExamResource::collection($exercises));
        } catch (\Exception $e) {
            return response()->apiResponse([], $e->getMessage(), false, 500);
        }
    }



    public function getExerciseQuestions(Request $request)
    {

        try {
            // Find the exercise
            $exercise = Excercise::find($request->exercise_id);
            if (!$exercise) {
                return response()->apiResponse('Exercise not found', 200, false);
            }

            $formmated_questions = [];
            switch ($exercise->type) {
                case "Multiple Choice":
                    $formmated_questions = $exercise->questions->map(function ($question) {
                        return [
                            "id" => $question->id,
                            "question" => $question->question,
                            "question_number" => $question->getNumber(),
                            "correct_answer" => $question->multiple_choice->getCorrectAnswer(),
                            "options" => $question->multiple_choice->getShuffledOptionsAttribute(),

                        ];
                    });
                    break;
                case "True or False":

                    $formmated_questions = $exercise->questions->map(function ($question) {
                        return [
                            "id" => $question->id,
                            "question" => $question->question,
                            "question_number" => $question->getNumber(),
                            "correct_answer" => $question->true_or_false->getCorrectAnswer(),
                        ];
                    });

                    break;
                case "Fill in the Blank":
                    $formmated_questions = $exercise->questions->map(function ($question) {
                        return [
                            "id" => $question->id,
                            "question" => $question->question,
                            "question_number" => $question->getNumber(),
                            "correct_answer" => $question->fill_in_the_blank->getCorrectAnswer(),
                        ];
                    });
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
                    'questions' => $formmated_questions,
                ],
            ]);
        } catch (ValidationException $e) {
            return response()->apiResponse($e->errors(), 200, false);
        }
    }




    public function take(Request $request)
    {
        try {
            // Find the student
            $student = Student::find($request->student_id);
            if (!$student) {
                return response()->apiResponse('Student not found', 200, false);
            }

            // Find the exercise
            $exercise = Excercise::find($request->exercise_id);
            if (!$exercise) {
                return response()->apiResponse('Exercise not found', 200, false);
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
            $new_collection = $collection->map(function ($item) {
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
