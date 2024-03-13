<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Excercise;
use Illuminate\Http\Request;
use App\Http\Resources\TakedExamResource;
use Illuminate\Validation\ValidationException;
class Exercisecontroller extends Controller
{
    public function takeExercises(Request $request){
        try {
            $validated_data = $request->validate([
                'excercise_id' => 'required',
                'student_id' => 'required',
    
            ]);
    
    
    
            $student = Student::find($request->student_id);
            $exercise = Excercise::find($request->excercise_id);
    
            if ($exercise) {
    
                if ($exercise->getTotalQuestions() == count($request->answers) || $exercise->getTotalAnswers() == 0) {
    
                    $taked_exam = $student->taked_exam()->create([
                        'excercise_id' => $exercise->id,
                    ]);
    
                    if ($taked_exam) {
                        foreach ($request->answers as $answer_data) {
                            $taked_exam->answers()->create($answer_data);
                        }
                        return response()->apiResponse(['data' => new TakedExamResource($taked_exam)]);
                    } else {
    
                        return response()->apiResponse("failed to create taked exam", 200, false);
                    }
    
                    // return response()->apiResponse(['data' => $exercise ]);
                } else {
                    return response()->apiResponse("answers did not match to the total exercise questions", 200, false);
                }
            } else {
                return response()->apiResponse("Exercise Did not exist", 200, false);
            }
        } catch (ValidationException $e) {
            return response()->apiResponse($e->errors(), 200, false);
        }
    }
}
