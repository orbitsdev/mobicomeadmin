<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->getFullName(),
            'student_id' =>$this->student? $this->student->id : null,
            'section' => $this->student  ?  $this->student->enrolled_section->section->title : null,
            'teacher_full_name' =>$this->student?  $this->student->enrolled_section->teacher->user->getFullName() : null,
          
            'role' => $this->role,
            'image'=> $this->getImage(),
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
