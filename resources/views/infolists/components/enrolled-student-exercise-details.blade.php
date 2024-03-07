<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    @foreach ($getRecord()->taked_exams as $taked_exam)
    <div class="grid grid-cols-12 border-b">
        <div class="col-span-8">
            <a href="{{ route('enrolled-teacher-view-exercise-score', ['record' => $taked_exam]) }}" class="p-2 text-blue-600 block capitalize" style="color: #3b82f6">{{ $taked_exam->excercise->title }}</a>
        </div>
        <div class="col-span-2">
            <p>Total Score: {{ $taked_exam->getTotalScore() }} / {{ $taked_exam->getTotalExerciseQuestions() }}</p>
        </div>
        <div class="col-span-2">
            <p>{{ Carbon\Carbon::parse($taked_exam->created_at)->format('F j, Y') }}</p>
        </div>
    </div>
@endforeach

</x-dynamic-component>
