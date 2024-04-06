<?php

use App\Livewire\Request\StudentListForRemoval;
use App\Models\Student;
use App\Models\Excercise;
use App\Livewire\ManageChapter;
use App\Livewire\StudentDetails;
use App\Livewire\Users\EditUser;
use App\Livewire\Users\ListUsers;
use App\Livewire\Users\UserDetails;
use App\Livewire\Lessons\EditLesson;
use App\Livewire\Teacher\ListSection;
use App\Livewire\TeacherListQuestion;
use Illuminate\Support\Facades\Route;
use App\Livewire\Chapters\EditChapter;
use App\Livewire\Chapters\ListLessons;
use App\Livewire\Lessons\CreateLesson;
use App\Livewire\Chapters\ListChapters;
use App\Livewire\Sections\ListSections;
use App\Livewire\Students\ListStudents;
use App\Livewire\Teachers\ListTeachers;
use App\Livewire\Chapters\CreateChapter;
use App\Livewire\Chapters\LessonDetails;
use App\Livewire\Chapters\ManageLessons;
use App\Livewire\TeacherQuestionDetails;
use App\Livewire\Chapters\ChapterDetails;
use App\Livewire\Exercises\EditExcercise;
use App\Livewire\Exercises\ListQuestions;
use App\Livewire\TeacherExcerciseDetails;
use App\Livewire\Teachers\ManageSections;
use App\Livewire\Exercises\ManageExercise;
use App\Livewire\Admin\Teacher\ListStudent;
use App\Livewire\Excercises\CreateExercise;
use App\Livewire\Excercises\ListExcercises;
use App\Livewire\Questions\QuestionDetails;
use App\Livewire\Chapters\EditChapterLesson;
use App\Livewire\EnrolledExcerciseScoreDetails;
use App\Livewire\Excercises\ExerciseDetails;
use App\Livewire\Exercises\ManageTrueOrFalse;
use App\Livewire\Teacher\TeacherEditExcercise;
use App\Livewire\Teacher\TeacherListExcercise;
use App\Livewire\Exercises\ManageFillInTheBlank;
use App\Livewire\Exercises\ManageMultipleChoice;
use App\Livewire\ExerciseScoreDetails;
use App\Livewire\Teacher\TeacherCreateExcercise;
use App\Livewire\Teacher\TeacherManageTrueOrFalse;
use App\Livewire\Teacher\TeacherManageFillInTheBlank;
use App\Livewire\Teacher\TeacherManageMultipleChoice;
use App\Livewire\Lessons\ListLessons as LessonsListLessons;
use App\Livewire\Lessons\LessonDetails as LessonsLessonDetails;
use App\Livewire\Teacher\Management\EnrolledStudentDetails;
use App\Livewire\Teacher\Management\ListOfHandledStudent;
use App\Livewire\Teacher\Management\ListTakedExcercise;
use App\Livewire\Teacher\TeacherDetails;
use App\Livewire\TeacherManagement\ListStudent as TeacherManagementListStudent;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // SAMPLES
//     Route::get('create-exam', function(){

//         $student = Student::find(1);
//         $exercise = Excercise::find(1); // Assuming you have the Exercise model

//         // Create a new TakedExam for the student
//         $taked_exam = $student->taked_exam()->create([
//             'excercise_id' => $exercise->id,
//         ]);


// // Static data for answers (question_id, user_answer, status)
// $answersData = [
//     ['taked_exam_id' => $taked_exam->id, 'question_id' => 1, 'answer' => 'Answer to question 1', 'status' => true],
//     ['taked_exam_id' => $taked_exam->id, 'question_id' => 2, 'answer' => 'Answer to question 2', 'status' => false],
//     // Add more answers for each question submitted by the student
// ];

// // $takedExam->answers()->createMany($answersData);

// // Create answers for the taked exam
// foreach ($answersData as $answerData) {
//     $taked_exam->answers()->create($answerData);
// }


//         return 'success';

//     });

    Route::get("student/{record}", StudentDetails::class )->name('view-student');
    Route::get("student/exercise/score/{record}", ExerciseScoreDetails::class)->name('teacher-view-exercise-score');

    Route::get("profile/{record}", UserDetails::class )->name('view-profile');
    Route::get("edit/profile/{record}", EditUser::class )->name('edit-profile');
    // Route::middleware(['can:admin-and-teacher'])->group(function(){

        Route::get("list-sections", \App\Livewire\Sections\ListSection::class )->name('list-sections');
       
        Route::middleware(['can:is-admin'])->group(function(){

            Route::get("list-users", ListUsers::class )->name('list-users');
            
            
            Route::get("list-teachers", ListTeachers::class )->name('list-teachers');
            Route::get("view-teacher-profile/{record}", TeacherDetails::class )->name('view-teacher-profile');
            
            Route::get("manage-teacher-sections/{record}", ManageSections::class )->name('manage-teacher-sections');
            Route::get("list-teacher-sections/{record}", ListSection::class )->name('list-teacher-sections');
            Route::get("list-teacher-section/students{record}", ListStudent::class )->name('list-teacher-section-students');
            
            Route::get("list-students", ListStudents::class )->name('list-students');
            Route::get("list-of-request-for-removal", StudentListForRemoval::class )->name('list-of-request-for-removal');
        
            Route::get("student-profile/{record}", StudentDetails::class )->name('student-profile');

         
            Route::get("list-excercises", ListExcercises::class)->name('list-excercises');
            Route::get("excercise/multiple-choice/{record}", ManageMultipleChoice::class)->name('manage-multiple-choice');
            Route::get("excercise/true-or-false/{record}", ManageTrueOrFalse::class)->name('manage-true-or-false');
            Route::get("excercise/fill-in-the-blank/{record}", ManageFillInTheBlank::class)->name('manage-fill-in-the-blank');
            Route::get("excercise/view/{record}",  ExerciseDetails::class)->name('view-exercise');
            // Route::get("manage-excercise/questions/{record}", ListQuestions::class)->name('manage-excercise-questions');
            Route::get("view-question/{record}", QuestionDetails::class)->name('view-question-details');
            Route::get("excercise/create", CreateExercise::class)->name('create-exercise');
            Route::get("excercise/edit/{record}", EditExcercise::class)->name('edit-exercise');
        });

        Route::middleware(['can:admin-and-teacher'])->group(function(){
            Route::get("list-chapters", ListChapters::class )->name('list-chapters');
            Route::get("create-chapter", CreateChapter::class)->name('create-chapter');
            Route::get("edit-chapter/{record}", EditChapter::class)->name('edit-chapter');
            Route::get("view-chapter/{record}", ChapterDetails::class )->name('view-chapter');
            Route::get("chapter-lessons-list/{record}", ListLessons::class )->name('chapter-lessons-list');
            Route::get("chapter/{record}lesson/create/", CreateLesson::class )->name('chapter-create-lesson');
            Route::get("chapter/lesson/edit/{record}", EditChapterLesson::class )->name('chapter-edit-lesson');

            Route::get("chapter/view/lesson/{record}", LessonDetails::class)->name('chapter-view-lesson');
            Route::get("view/lesson/{record}", LessonDetails::class)->name('view-lesson');
            Route::get("lesson/edit/{record}", EditLesson::class )->name('edit-lesson');
            Route::get("list-lessons", LessonsListLessons::class)->name('list-lessons');
            Route::get("lessons/view/lesson/{record}", LessonsLessonDetails::class)->name('lessons-lessonn-details');

        });

        // make it available to admin and  teacher







    // });


    //TEACHER
    Route::get("teacher-list-excercises", TeacherListExcercise::class)->name('teacher-list-excercises');
    Route::get("teacher-excercise/create", TeacherCreateExcercise::class)->name('teacher-create-exercise');
    Route::get("teacher-excercise/edit/{record}", TeacherEditExcercise::class)->name('teacher-edit-exercise');
    Route::get("teacher-excercise/multiple-choice/{record}", TeacherManageMultipleChoice::class)->name('teacher-manage-multiple-choice');
    Route::get("teacher-excercise/true-or-false/{record}", TeacherManageTrueOrFalse::class)->name('teacher-manage-true-or-false');
    Route::get("teacher-excercise/fill-in-the-blank/{record}", TeacherManageFillInTheBlank::class)->name('teacher-manage-fill-in-the-blank');
    Route::get("teacher-excercise/view/{record}",  TeacherExcerciseDetails::class)->name('teacher-view-exercise');

    // Route::get("teacher-manage-excercise/questions/{record}", TeacherListQuestion::class)->name('teacher-manage-excercise-questions');
    // Route::get("teacher-manage-excercise/questions/{record}", ListQuestions::class)->name('teacher-manage-excercise-questions');
    Route::get("teacher-view-question/{record}", TeacherQuestionDetails::class)->name('teacher-view-question-details');
    Route::get("teacher-list-sections", ListSections::class)->name('teacher-list-sections');
    Route::get("teacher-list-sections-users/{record}", TeacherManagementListStudent::class)->name('teacher-list-sections-users');
    Route::get("teacher-list-of-enrolled-students", ListOfHandledStudent::class)->name('teacher-list-of-enrolled-students');
    Route::get("teacher-enrolled-student-view/{record}", EnrolledStudentDetails::class )->name('enrolled-view-student');

    Route::get("teacher/enrolled/student/exercise/score/{record}", EnrolledExcerciseScoreDetails::class)->name('enrolled-teacher-view-exercise-score');
    Route::get("teacher/student/taked/exercises", ListTakedExcercise::class)->name('teacher-list-taked-exercises');





    // Route::get("view-excercise/{record}", ExerciseDetails::class)->name('view-excercise');
});
// Route::get("users-details{record}/", UserDetails::class )->name('users-details');
