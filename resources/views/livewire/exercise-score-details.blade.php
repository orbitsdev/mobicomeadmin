<div class="container mx-auto px-4">
    

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
                <div class="mt-4 flex flex-col">
                    <div class="p-4 border rounded-md shadow-md">
                        <p class="flex items-center">
                            <span class="text-gray-700"><strong>Question:</strong> {{ $answer->question->getNumber() }}. {{ $answer->question->question }}</span>
                            @if ($answer->is_correct)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            @endif
                        </p>
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
                    </div>
                </div>
            @endforeach
    
            <div class="mt-4 p-4 bg-gray-800 rounded-md text-white">
                <p>Total Score: {{ $record->getRealScore() }}</p>
                <p>Total Questions: {{ $record->getTotalExerciseQuestions() }}</p>
            </div>
        </div>
    </div>
    
</div>
