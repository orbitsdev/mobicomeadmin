<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EnrolledSection;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{


    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480', // Max file size 20MB
        ]);

        $userId = $request->input('user_id');

        // Check if the user ID is provided and exists
        if (!$userId) {
            return response()->apiResponse('User ID is required', 200, false);
        }

        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return response()->apiResponse('User Not Found', 200, false);
        }

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();

        // Store the image in the specified directory within the public disk
        $image->storeAs('users-profiles', $imageName, 'public');

        $user->profile_photo_path = 'users-profiles/'.$imageName;
        $user->save();

        // Return API response using custom macro

        return response()->apiResponse(['data' => $user->getImage()]);

    }

    public function login(Request $request){
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
    }

    public function logout(Request $request){
        try {
            // Revoke the current user's token

            $accessToken = $request->bearerToken();
            if ($accessToken) {

                $token = PersonalAccessToken::findToken($accessToken);
                $token->delete();
                // $request->user()->tokens()->delete();
            }

            return response()->apiResponse('User logged out successfully');
        } catch (ValidationException $e) {

            // Handle any exceptions that might occur
            return response()->apiResponse($e->getMessage(), 200, false);
        }
    }


    public function register(Request $request){
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
    }
}
