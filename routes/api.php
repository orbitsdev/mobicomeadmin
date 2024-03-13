<?php

use App\Models\User;
use App\Models\Section;
use App\Models\Student;
use App\Models\Excercise;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserCollection;
use App\Http\Resources\SectionResource;
use App\Http\Resources\TakedExamResource;
use App\Models\EnrolledSection;
use Illuminate\Validation\ValidationException;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', function (Request $request) {
    try {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('device_name')->plainTextToken;

        return response()->apiResponse(['data' => new UserResource($user), 'token' => $token]);
    } catch (ValidationException $e) {
        // Validation failed, return validation errors
        return response()->apiResponse($e->errors(), 200, false);
    }
})->name('app.login');

Route::post('/register', function (Request $request) {
    try {
        $validated_data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'enrolled_section_id' => 'required',
        ]);

        $enrolled_section = EnrolledSection::find($request->enrolled_section_id);

        if ($enrolled_section) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Student',
            ]);

            $user->student()->create([
                'enrolled_section_id' => $enrolled_section->id,
                'is_approved' => false,
            ]);

            // Generate token for the newly registered user
            $token = $user->createToken('device_name')->plainTextToken;

            return response()->apiResponse(['data' => new UserResource($user), 'token' => $token]);
        } else {
            return response()->apiResponse('Section Not Found', 200, false);
        }
    } catch (ValidationException $e) {
        return response()->apiResponse($e->errors(), 200, false);
    }
})->name('app.register');


Route::post('/take/exercise', function (Request $request) {
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
})->name('app.take-exercise');




Route::get('/sections', function () {
    try {



        return response()->apiResponse(
            [
                'data' =>  SectionResource::collection(
                    EnrolledSection::whereHas('teacher')->get()->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'title' => $item->section->title . ' (' . $item->teacher->user->getFullName() . ')',
                        ];
                    })
                )
            ]
        );
    } catch (ValidationException $e) {
        return response()->apiResponse($e->errors(), 200, false);
    }
})->name('all-sections');
