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

                        @switch($record->excercise->type)
                        @case('Multiple Choice')
{{-- 
                            @foreach ($answer->questions->multiple_choice->getShuffledOptionsAttribute() as  $option)
                                    <p>

                                        {{$option}}
                                    </p>
                            @endforeach --}}
                            <p>Actual Answer: {{ $answer->question->multiple_choice->correct_answer }}</p>
                            <p>User Answer: {{ $answer->answer }}</p>
                            <p>Is Correct: {{ $answer->compareUserAnswer(actual_answer: $answer->question->multiple_choice->correct_answer, type: $record->excercise->type) }}</p>
                            @break

                        @case('True or False')
                        <p>Actual Answer: {{ $answer->question->true_or_false->getTextAnswer()}}</p>
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

                    </p>
                    {{-- <p><strong>Status:</strong> {{ $answer->status ? 'Correct' : 'Incorrect' }}</p> --}}
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            <div class="p-4 border rounded-md shadow-md">
                <p><strong>Total Score:</strong> {{ $record->getTotalScore() }}</p>
                <p><strong>Total Questions:</strong> {{ $record->getTotalExerciseQuestions() }}</p>
            </div>
        </div>
    </div>
</div>
