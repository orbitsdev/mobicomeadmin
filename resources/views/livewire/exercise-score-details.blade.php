<div class="container mx-auto px-4">
    <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
        <div class="ml-4 mt-2">
            <h1 class="text-xl font-semibold leading-6 text-gray-900">
                Score Details
            </h1>
        </div>
        <div class="ml-4 mt-2 flex-shrink-0">
            <x-back-button :url="redirect()->back()->getTargetUrl()"> Back </x-back-button>
        </div>
    </div>

    <div class="px-4 py-5 sm:px-6 mb-4 bg-white mt-4 ">
        <div class="white">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-3xl font-bold text-gray-900">{{ $record->excercise->title }}</h2>
                <div class="flex items-center mt-2">
                    <span class="text-blue-700 ml-2 text-sm mr-2">Total  {{ $record->excercise->getTotalQuestions() }}</span>
                    <span class="inline-block px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">{{ $record->excercise->type }}</span>
                </div>
            </div>

            <div class="mt-2 prose max-w-none border-b py-2 mb-6">
                {{-- Markdown content here --}}
            </div>
        </div>

        @foreach ($record->answers as $answer)
            <div class="mt-4">
                <div class="p-4 border rounded-md shadow-md">
                    <p><strong>Question:</strong> {{ $answer->question->getNumber() }}. {{ $answer->question->question }}</p>
                    @if ($record->excercise->type === 'Multiple Choice')
                        <div class="flex flex-wrap mt-2">
                            @foreach ($answer->question->multiple_choice->getShuffledOptionsAttribute() as $option)
                                <label class="inline-flex items-center mr-4 mb-2">
                                    <span class="text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <p>Actual Answer: {{ $answer->question->actual_answer }}</p>
                    <p>User Answer: {{ $answer->answer }}</p>
                    <p>Is Correct: {{ $answer->is_correct }}</p>
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            <div class="p-4 border rounded-md shadow-md">
                <p>Total Score: {{ $record->getRealScore() }}</p>
                <p>Total Questions: {{ $record->getTotalExerciseQuestions() }}</p>
            </div>
        </div>
    </div>
</div>
