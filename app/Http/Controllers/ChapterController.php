<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Resources\ModelResource;
use Illuminate\Validation\ValidationException;

class ChapterController extends Controller
{
    public function getChapters(Request $request)
    {
        try {
            // Join the chapter_numbers table and order by its 'number' column
            $chapters = Chapter::join('chapter_numbers', 'chapters.chapter_number_id', '=', 'chapter_numbers.id')
                                ->orderBy('chapter_numbers.number')
                                ->get();

            return response()->apiResponse([
                'data' => ModelResource::collection($chapters->map(function($item){
                    return [
                        'id'=> $item->id,
                        'title'=>$item->title,
                        'description'=>$item->description,
                        'image_path'=>$item->getImage(),
                        'created_at' => Carbon::parse($item->created_at)->format('F j, Y g:i A'),
                        'updated_at' => Carbon::parse($item->updated_at)->format('F j, Y g:i A'),
                        'number'=>$item->number(),
                        'total_lessons'=>$item->getTotalLessons(),
                        'full_title'=>$item->getTitle(),
                        // 'lessons'=> $item->lessons->map(function($lesson){
                        //     return [
                        //         "id"=>  $lesson->id,
                        //         "chapter_id"=> $lesson->chapter_id,
                        //         "lesson_number_id"=> $lesson->lesson_number_id,
                        //         "title"=> $lesson->title,
                        //         "title_number"=> $lesson->title_number,
                        //         "content"=> $lesson->content,
                        //         "image_path"=> $lesson->getActualImage(),
                        //         "video_path"=>$lesson->getActualVideo(),
                        //         "image_type"=> $lesson->image_type,
                        //         "video_type"=> $lesson->video_type,
                        //         "lesson_number"=>$lesson->lesson_number,
                        //         'created_at' => Carbon::parse($lesson->created_at)->format('F j, Y g:i A'),
                        // 'updated_at' => Carbon::parse($lesson->updated_at)->format('F j, Y g:i A'),
                        //     ];
                        // }),
                    ];
                })),
            ]);
        } catch (ValidationException $e) {
            return response()->apiResponse($e->errors(), 200, false);
        }
    }
    public function getChapterLessons(Request $request)
    {
        try {
            
            $lessons = Lesson::where('chapter_id', $request->chapter_id)->get();
            return response()->apiResponse([
                'data' => ModelResource::collection($lessons->map(function($lesson){
                    return [
                                "id"=>  $lesson->id,
                                "chapter_id"=> $lesson->chapter_id,
                                "lesson_number_id"=> $lesson->lesson_number_id,
                                "title"=> $lesson->title,
                                "title_number"=> $lesson->title_number,
                                "content"=> $lesson->content,
                                "image_path"=> $lesson->getActualImage(),
                                "video_path"=>$lesson->getActualVideo(),
                                "image_type"=> $lesson->image_type,
                                "video_type"=> $lesson->video_type,
                                "lesson_number"=>$lesson->lesson_number,
                                'created_at' => Carbon::parse($lesson->created_at)->format('F j, Y g:i A'),
                        'updated_at' => Carbon::parse($lesson->updated_at)->format('F j, Y g:i A'),
                            ];
                })),
                
            ]);
            
        } catch (ValidationException $e) {
            return response()->apiResponse($e->errors(), 200, false);
        }
    }
}
