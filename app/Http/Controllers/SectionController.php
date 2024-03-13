<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnrolledSection;
use App\Http\Resources\SectionResource;
use Illuminate\Validation\ValidationException;

class SectionController extends Controller
{
    public function getSections(Request $request)
    {
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
    }
}
