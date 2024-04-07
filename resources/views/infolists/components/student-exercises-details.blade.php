<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        <div class="grid grid-cols-12 border-b">
            <div class="col-span-6">
                <h2 class="text-lg font-semibold mb-2">Exam Records</h2>
            </div>
            <div class="col-span-2">
                <h2 class="text-lg font-semibold mb-2">Type</h2>
            </div>
            <div class="col-span-2">
                <h2 class="text-lg font-semibold mb-2">Score</h2>
            </div>
            <div class="col-span-2">
                <h2 class="text-lg font-semibold mb-2">Date</h2>
            </div>
        </div>

        @foreach ($getRecord()->taked_exams as $taked_exam)
            <div class="grid grid-cols-12 border-b">
                <div class="col-span-6">
                    <a href="{{ route('exercise-official-result', ['record' => $taked_exam]) }}"
                        class="p-2 text-blue-600 block capitalize hover:underline">{{ $taked_exam->excercise->title }}</a>
                </div>
                <div class="col-span-2">
                    <span class="text-sm text-gray-600">{{ $taked_exam->excercise->type }}</span>
                </div>
                <div class="col-span-2">
                    <p>Total Score: <span class="text-green-600">{{ $taked_exam->getRealScore() }}</span> / {{ $taked_exam->getTotalExerciseQuestions() }}</p>
                </div>
                <div class="col-span-2">
                    <p>{{ Carbon\Carbon::parse($taked_exam->created_at)->format('F j, Y') }}</p>
                </div>
            </div>
            
        @endforeach
    </div>
</x-dynamic-component>
