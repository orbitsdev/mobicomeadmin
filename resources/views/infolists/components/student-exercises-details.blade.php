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
            <div class="bg-gray-100 rounded-lg p-4 mt-2">
                <h2 class="text-lg font-semibold mb-2">Feedback:</h2>
                <div class="flex items-center mb-2">
                    <p class="mr-2">{{ $taked_exam->feed->rate }}</p>
                    <div class="flex">
                        @for ($i = 0; $i < $taked_exam->feed->rate; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.697 1.246a1 1 0 011.606 0l1.115 2.55a.5.5 0 00.29.29l2.55 1.115a1 1 0 010 1.607l-2.55 1.115a.5.5 0 00-.29.29l-1.115 2.55a1 1 0 01-1.607 0l-1.115-2.55a.5.5 0 00-.29-.29l-2.55-1.115a1 1 0 010-1.606l2.55-1.115a.5.5 0 00.29-.29l1.115-2.55zM10 4.018L8.426 6.44a.5.5 0 00.06.625l1.197 1.098-1.13 2.587a.5.5 0 00.719.602L10 10.983l2.229 1.17a.5.5 0 00.72-.602l-1.13-2.587 1.197-1.098a.5.5 0 00.06-.625L10 4.018z" clip-rule="evenodd" />
                            </svg>
                        @endfor
                    </div>
                </div>
                <p class="text-gray-700"><span class="font-semibold">Message:</span> {{ $taked_exam->feed->message }}</p>
                <p class="text-gray-700"><span class="font-semibold">Is Read:</span> {{ $taked_exam->feed->is_read ? 'Yes' : 'No' }}</p>
            </div>
            @endif
        @endforeach
    </div>
</x-dynamic-component>
