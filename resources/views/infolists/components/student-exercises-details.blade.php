<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>

        @foreach ($getRecord()->taked_exams as $taked_exam)
            <div class="grid grid-cols-12 border-b">
                <div class="col-span-8">
                    <a href="{{ route('teacher-view-exercise-score', ['record' => $taked_exam]) }}"
                        class="p-2 text-blue-600 block capitalize"
                        style="color: #3b82f6">{{ $taked_exam->excercise->title }}</a>
                </div>
                <div class="col-span-2">
                    <p>Total Score: {{ $taked_exam->getTotalScore() }} / {{ $taked_exam->getTotalExerciseQuestions() }}
                    </p>
                </div>
                <div class="col-span-2">
                    <p>{{ Carbon\Carbon::parse($taked_exam->created_at)->format('F j, Y') }}</p>
                </div>
            </div>
            @if ($taked_exam->feed)
                <div class="bg-gray-50  rounded-lg p-2 text-xs">
                    <h2 class=" ">Feedback:</h2>
                    <div class="">
                        <p class="col-span-1 text-sm text-gray-600"><span class="">Rate:</span>
                            {{ $taked_exam->feed->rate }}</p>
                        <p class="col-span-1 text-sm text-gray-600 "><span class="">Message:</span>
                            {{ $taked_exam->feed->message }}</p>
                        <p class="col-span-1 text-sm text-gray-600"><span class="">Is Read:</span>
                            {{ $taked_exam->feed->is_read ? 'Yes' : 'No' }}</p>

                    </div>
                </div>
            @endif
        @endforeach
    </div>




</x-dynamic-component>
