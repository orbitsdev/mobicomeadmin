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
                    <div class="flex text-4xl ">
                        @php
                            $ratingLevel = '';
                            switch ($taked_exam->feed->rate) {
                                case 1:
                                    $ratingLevel = '🙂'; // Easy
                                    break;
                                case 2:
                                    $ratingLevel = '😊'; // Moderately easy
                                    break;
                                case 3:
                                    $ratingLevel = '😐'; // Moderate
                                    break;
                                case 4:
                                    $ratingLevel = '😕'; // Moderately difficult
                                    break;
                                case 5:
                                    $ratingLevel = '😫'; // Difficult
                                    break;
                                default:
                                    $ratingLevel = '😐'; // Default to Moderate if not specified
                            }
                        @endphp
                        <span>{{ $ratingLevel }}</span>
                    </div>
                </div>
                <p class="text-gray-700"><span class="font-semibold">Message:</span> {{ $taked_exam->feed->message }}</p>
            </div>
            
            @endif
        @endforeach
    </div>
</x-dynamic-component>
