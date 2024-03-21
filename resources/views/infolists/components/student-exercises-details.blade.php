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
                    <a href="{{ route('teacher-view-exercise-score', ['record' => $taked_exam]) }}"
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
            @if ($taked_exam->feed)
            <div class="bg-gray-100 rounded-lg p-2 text-xs mt-2">
                <h2 class="text-lg font-semibold mb-2">Feedback:</h2>
                <div class="grid grid-cols-1">
                    <p>{{ $taked_exam->feed->rate }} <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></p>
                    <p>{{ $taked_exam->feed->message }} <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></p>
                    <p>{{ $taked_exam->feed->is_read ? 'Yes' : 'No' }} {!! $taked_exam->feed->is_read ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>' : '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' !!}</p>
                </div>
            </div>
            
            @endif
        @endforeach
    </div>
</x-dynamic-component>
