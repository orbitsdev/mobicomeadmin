<div class="container mx-auto px-4">
    <div class="flex flex-col sm:flex-row items-center justify-between">
        <h1 class="text-2xl font-semibold leading-6 text-gray-900 mb-2">Score Details</h1>
        <x-back-button :url="redirect()->back()->getTargetUrl()"> Back </x-back-button>
    </div>

    <div class="bg-white rounded-md shadow-md p-6 mt-4">
        <h2 class="text-xl font-bold text-gray-900">{{ $record->excercise->title }}</h2>
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

                    @switch($record->excercise->type)
                        @case('Multiple Choice')
                            <p>Actual Answer: {{ $answer->question->multiple_choice->correct_answer }}</p>
                            <p>User Answer: {{ $answer->answer }}</p>
                            <p>Is Correct: {{ $answer->compareUserAnswer(actual_answer: $answer->question->multiple_choice->correct_answer, type: $record->excercise->type) }}</p>
                            @break

                        @case('True or False')
                            <p>Actual Answer: {{ $answer->question->true_or_false->getTextAnswer() }}</p>
                            <p>User Answer: {{ $answer->answer }}</p>
                            <p>Is Correct: {{ $answer->compareUserAnswer(actual_answer: $answer->question->true_or_false->getTextAnswer(), type: $record->excercise->type) }}</p>
                            @break

                        @case('Fill in the Blank')
                            <p>Actual Answer: {{ $answer->question->fill_in_the_blank->correct_answer }}</p>
                            <p>User Answer: {{ $answer->answer }}</p>
                            <p>Is Correct: {{ $answer->compareUserAnswer(actual_answer: $answer->question->fill_in_the_blank->correct_answer, type: $record->excercise->type) }}</p>
                            @break

                        @default
                            {{-- Handle default case --}}
                    @endswitch
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            <div class="border rounded-md shadow-md p-4">
                <p><strong>Total Score:</strong> {{ $record->getRealScore() }}</p>
                <p><strong>Total Questions:</strong> {{ $record->getTotalExerciseQuestions() }}</p>
            </div>
        </div>
    </div>
</div>
