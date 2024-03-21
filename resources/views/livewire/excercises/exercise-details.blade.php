<div class="container mx-auto px-4">
    <div class="py-4 bg-white shadow-md mb-4">
        <div class="flex items-center justify-between">
            <div class="ml-4">
                <h1 class="text-2xl font-semibold text-gray-900">{{ $record->title }}</h1>
                <div class="flex items-center mt-2 text-sm text-gray-600">
                    <span>Total {{ $record->getTotalQuestions() }}</span>
                    <span class="inline-block px-2 py-1 ml-2 text-white bg-blue-500 rounded-full">{{ $record->type }}</span>
                </div>
            </div>
            <div class="ml-4">
                <x-back-button :url="route('list-excercises')">BACK</x-back-button>
            </div>
        </div>
        <hr class="my-4 border-t border-gray-200">
        <div class="prose max-w-none">
            @markdown($record->description)
        </div>
    </div>

    <div class="bg-white shadow-md rounded-md p-6">
        @foreach ($record->questions as $question)
            <div class="mt-6">
                <h2 class="text-lg font-medium text-gray-900">{{ $question->getNumber() }}. {{ $question->question }}</h2>
                <div class="mt-2 space-y-4">
                    <fieldset>
                        @switch($question->excercise->type)
                            @case('Multiple Choice')
                                @foreach ($question->multiple_choice->getShuffledOptionsAttribute() as $key => $option)
                                    <div class="flex items-center">
                                        <input type="radio" class="mr-2" disabled>
                                        <p class="{{ $question->multiple_choice->getCorrectAnswer() == $option ? 'text-green-500' : 'text-gray-500' }}">{{ $option }}</p>
                                    </div>
                                @endforeach
                                @break

                            @case('True or False')
                                <div class="flex items-center">
                                    <input type="radio" class="mr-2" disabled>
                                    <p class="text-gray-600">{{ $question->true_or_false->getTextAnswer() }}</p>
                                </div>
                                @break

                            @case('Fill in the Blank')
                                <p>{{ $question->fill_in_the_blank->getCorrectAnswer() }}</p>
                                @break

                            @default
                                <!-- Handle other types of questions -->
                        @endswitch
                    </fieldset>
                </div>
            </div>
        @endforeach
    </div>
</div>
