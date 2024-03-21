<div class="container mx-auto px-4">
    <div class="bg-white rounded-md shadow-md p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Score Details</h1>
            <x-back-button :url="redirect()->back()->getTargetUrl()" class="text-gray-700">Back</x-back-button>
        </div>
        
        <div class="mt-4">
            <h2 class="text-xl font-semibold text-gray-900">{{ $record->excercise->title }}</h2>
            <div class="flex items-center mt-2">
                <span class="text-blue-700 text-sm mr-2">Total Questions: {{ $record->excercise->getTotalQuestions() }}</span>
                <span class="inline-block px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">{{ $record->excercise->type }}</span>
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

        <div class="mt-4 prose max-w-none border-b py-2 mb-6">
            {{-- Markdown content here --}}
        </div>
        
        @foreach ($record->answers as $answer)
            <div class="mt-4">
                <div class="p-4 border rounded-md shadow-md">
                    <p class="flex items-center text-gray-700">
                        <span class="mr-auto"><strong>Question:</strong> {{ $answer->question->getNumber() }}. {{ $answer->question->question }}</span>
                        @if ($answer->is_correct)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        @endif
                    </p>
                    @if ($record->excercise->type === 'Multiple Choice')
                        <div class="mt-2 flex flex-wrap">
                            @foreach ($answer->question->multiple_choice->getShuffledOptionsAttribute() as $option)
                                <label class="inline-flex items-center mr-4 mb-2 text-gray-700">{{ $option }}</label>
                            @endforeach
                        </div>
                    @endif
                    <p class="text-gray-700">Actual Answer: {{ $answer->question->actual_answer }}</p>
                    <p class="text-gray-700">User Answer: {{ $answer->answer }}</p>
                </div>
            </div>
        @endforeach

        <div class="mt-4 p-4 bg-gray-800 rounded-md text-white">
            <p>Total Score: {{ $record->getRealScore() }}</p>
            <p>Total Questions: {{ $record->getTotalExerciseQuestions() }}</p>
        </div>
    </div>
</div>
