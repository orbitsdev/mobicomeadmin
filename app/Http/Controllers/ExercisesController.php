<?php

namespace App\Http\Controllers;

use App\Models\Excercise;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exact;
use App\Http\Resources\ModelResource;
use Illuminate\Validation\ValidationException;

class ExercisesController extends Controller
{
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
}
