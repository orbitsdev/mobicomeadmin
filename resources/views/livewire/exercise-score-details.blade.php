<div class="container mx-auto px-4">
    <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
        <h1 class="text-xl font-semibold leading-6 text-gray-900">Score Details</h1>
        <x-back-button :url="redirect()->back()->getTargetUrl()"> Back </x-back-button>
    </div>

    <div class="bg-white rounded-md shadow-md p-6 mt-4">
        <h2 class="text-2xl font-bold text-gray-900">{{ $record->excercise->title }}</h2>
        <div class="flex items-center mt-2">
            <span class="text-sm text-blue-700 mr-2">Total {{ $record->excercise->getTotalQuestions() }} Questions</span>
            <span class="inline-block px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">{{ $record->excercise->type }}</span>
        </div>

        <div class="prose mt-4 max-w-none border-b py-2 mb-6">
            {{-- Markdown content here --}}
        </div>

        @foreach ($record->answers as $answer)
            <div class="mt-4">
                <div class="border rounded-md shadow-md p-4">
                    <p><strong>Question:</strong> {{ $answer->question->getNumber() }}. {{ $answer->question->question }}</p>

                    @if ($record->excercise->type === 'Multiple Choice')
                        <div class="flex flex-wrap mt-2">
                            @foreach ($answer->question->multiple_choice->getShuffledOptionsAttribute() as $option)
                                <div class="flex items-center mr-4 mb-2">
                                    <div class="w-4 h-4 flex items-center justify-center border border-gray-300 rounded-full mr-2">
                                        @if ($answer->answer === $option)
                                            <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9.05 15.63a1 1 0 0 1-1.45-1.3l3.54-4.63-1.91-2.5a1 1 0 1 1 1.56-1.25l2.48 3.25 4.6-6.32a1 1 0 1 1 1.6 1.2l-5.5 7.54a1 1 0 0 1-1.6.1l-3.38-4.17-1.75 2.29z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="text-sm leading-5">{{ $option }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p><strong>Actual Answer:</strong> {{ $answer->getActualAnswer() }}</p>
                        <p><strong>User Answer:</strong> {{ $answer->answer }}</p>
                        <p><strong>Is Correct:</strong> {{ $answer->compareUserAnswer() }}</p>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            <div class="border rounded-md shadow-md p-4">
                <p><strong class="text-xl">Total Score:</strong> {{ $record->getRealScore() }}</p>
                <p><strong>Total Questions:</strong> {{ $record->getTotalExerciseQuestions() }}</p>
            </div>
        </div>
    </div>
</div>
