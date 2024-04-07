<div>

    {{-- @dump($record->excercise) --}}

        @if(request()->routeIs('exercise-official-result'))
            @can('is-admin')
                
            <div class="flex itemce justify-end"> <x-back-button-2 :url="route('student-profile',['record'=> $record->student])"> Back</x-back-button-2> </div>
            @endcan
            @can('is-teacher')
            <div class="flex itemce justify-end"> <x-back-button-2 :url="route('enrolled-view-student',['record'=> $record->student])"> Back</x-back-button-2> </div>
                
            @endcan
        
        @endif
    <div class="bg-white rounded-md shadow-md p-8 mt-6">

        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-9">
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-gray-900 uppercase">{{ $record->excercise->title }}</h2>
                    <div class="flex items-center mt-2">
                        <span class="text-blue-700 text-sm mr-2">Total Questions:
                            {{ $record->excercise->getTotalQuestions() }}</span>
                        <span
                            class="inline-block px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">{{ $record->excercise->type }}</span>
                    </div>
                    <p class="text-md mt-2">Name: <span
                            class="uppercase font-semibold">{{ $record->student ? $record->student->user->getFullName() : '' }}</span>
                    </p>
                </div>
            </div>

            <div class="col-span-3 flex items-center justify-center flex-col">
                <h1 class="text-3xl font-semibold">SCORE</h1>
                <h1 class="text-4xl font-semibold">{{ $record->getRealScore() }} /
                    {{ $record->excercise->getTotalQuestions() }}</h1>
            </div>
        </div>

        <div class="mt-2 border-t prose max-w-none py-2 mb-6">
            @markdown($record->excercise->description)
        </div>



        @if ($record->feed)
            <div class="mt-6 border-t">

                <h1 class="text-gray-800 uppercase text-lg font-semibold mt-4">FEED</h1>
                <div class="mb-6 mt-4 bg-blue-50 rounded p-6">

                    <div class="flex items-start mt-4">
                        <div class="text-center flex items-center justify-start flex-col mr-6">
                            <p class="">
                                @switch($record->feed->rate)
                                    @case(1)
                                        <span class="text-7xl" role="img" aria-label="Difficult">😫</span>
                                    <p class="text-sm text-gray-600 mt-2">Difficulty</p>
                                @break

                                @case(2)
                                    <span class="text-7xl" role="img" aria-label="Moderately difficult">😕</span>
                                    <p class="text-sm text-gray-600 mt-2">Moderately difficult</p>
                                @break

                                @case(3)
                                    <span class="text-7xl" role="img" aria-label="Moderate">😐</span>
                                    <p class="text-sm text-gray-600 mt-2">Moderate</p>
                                @break

                                @case(4)
                                    <span class="text-7xl" role="img" aria-label="Moderately easy">😊</span>
                                    <p class="text-sm text-gray-600 mt-2">Moderately easy</p>
                                @break

                                @case(5)
                                    <span class="text-7xl" role="img" aria-label="Easy">🙂</span>
                                    <p class="text-sm text-gray-600 mt-2">Easy</p>
                                @break

                                @default
                                    <span class="text-7xl" role="img" aria-label="Moderate">😐</span>
                                    <p class="text-sm text-gray-600 mt-2">Moderate</p>
                            @endswitch
                            </p>
                        </div>

                        <div class="text-gray-700">

                            <p class="mt-2">
                                {{ $record->feed->message }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif





        <div class="mt-6 border-t py-2">

            @switch($record->excercise->type)
                @case(\App\Models\Excercise::MULTIPLECHOICE)
                    <div class="mt-6">
                        @foreach ($record->answers as $answer)
                            <div class="bg-white rounded-md shadow-md mb-6">
                                <div class="p-4 border-b">
                                    <h2 class="text-md font-semibold text-gray-600">Question
                                        {{ $answer->question->getNumber() }}</h2>
                                </div>
                                <div class="p-4">
                                    <p class="text-gray-700 ">{{ $answer->question->question }}</p>
                                </div>
                                @foreach ($answer->question->multiple_choice->getShuffledOptionsAttribute() as $option)
                                    <div
                                        class="px-4 py-2 text-sm border-t 
                @if (
                    $answer->compareUserAnswer($answer->question->multiple_choice->getCorrectAnswer(), $record->excercise->type) ==
                        'Correct') {{ $option === $answer->answer ? 'bg-green-50 border border-green-400 text-green-600' : '' }} 
                @elseif (
                    $answer->compareUserAnswer($answer->question->multiple_choice->getCorrectAnswer(), $record->excercise->type) ==
                        'Wrong') 
                    {{ $option === $answer->answer ? 'bg-red-50 border border-red-300 text-red-600' : '' }} 
                @else 
                    {{ $option === $answer->answer ? 'bg-white text-gray-600' : '' }} @endif">
                                        <label class="flex items-center py-2">
                                            @if ($option === $answer->answer)
                                                @if (
                                                    $answer->compareUserAnswer($answer->question->multiple_choice->getCorrectAnswer(), $record->excercise->type) ==
                                                        'Correct')
                                                    <svg class="w-6 h-6 text-green-500 mr-2" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @elseif (
                                                    $answer->compareUserAnswer($answer->question->multiple_choice->getCorrectAnswer(), $record->excercise->type) ==
                                                        'Wrong')
                                                    <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                @endif
                                            @endif
                                            <input type="radio" name="answer_{{ $answer->question->id }}"
                                                value="{{ $option }}"
                                                class="mr-2 appearance-none hover:checked:bg-gray-400 checked:bg-gray-400"
                                                {{ $option === $answer->answer ? 'checked' : '' }} disabled>
                                            <span class="">{{ $option }}</span>
                                        </label>
                                    </div>
                                @endforeach

                                @if (
                                    $answer->compareUserAnswer($answer->question->multiple_choice->getCorrectAnswer(), $record->excercise->type) ==
                                        'Wrong')
                                    <div class="p-4 border-r border-l border-b bg-red-50 border-red-300">
                                        <div class="">
                                            <p class="text-gray-700 ">Correct Answer</p>
                                            <div class="mt-6">
                                                <input type="radio" class="checked:bg-gray-400"
                                                    name="correct_answer_{{ $answer->question->id }}"
                                                    value="{{ $answer->question->multiple_choice->getCorrectAnswer() }}"
                                                    checked>
                                                <label class="text-gray-600  ml-2"
                                                    for="correct_answer">{{ $answer->question->multiple_choice->getCorrectAnswer() }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @break

                @case(\App\Models\Excercise::TRUE_OR_FALSE)
                <div class="grid grid-cols-1  gap-6">
                    @foreach ($record->answers as $answer)
                        <div class="bg-white rounded-md shadow-md">
                            <div class="p-4 border-b">
                                <h2 class="text-md font-semibold text-gray-600">Question {{ $answer->question->getNumber() }}</h2>
                            </div>
                            <div class="p-4">
                                <p class="text-gray-700">{{ $answer->question->question }}</p>
                            </div>
                            <div class="px-4 py-2 border-t">
                                @if ($answer->compareUserAnswer($answer->question->true_or_false->getTextAnswer(), $record->excercise->type) == 'Correct')
                                    <div class="flex items-center text-green-600">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>{{$answer->answer}}</span>
                                    </div>
                                    @else
                                    <div class="flex items-center text-red-600">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span>{{$answer->answer}}</span>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-gray-700">Correct Answer:</p>
                                        <p class="text-gray-600">{{ $answer->question->true_or_false->getTextAnswer() }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @break

                @case(\App\Models\Excercise::FILL_IN_THE_BLANK)
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($record->answers as $answer)
                        <div class="bg-white rounded-md shadow-md">
                            <div class="p-4 border-b">
                                <h2 class="text-md font-semibold text-gray-600">Question {{ $answer->question->getNumber() }}</h2>
                            </div>
                            <div class="p-4">
                                <p class="text-gray-700">{{ $answer->question->question }}</p>
                            </div>
                            <div class="px-4 py-2 border-t">
                                @if ($answer->compareUserAnswer($answer->question->fill_in_the_blank->getCorrectAnswer(), $record->excercise->type) == 'Correct')
                                    <div class="flex items-center text-green-600">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <input type="text" value="{{ $answer->answer }}" class="border-none bg-transparent text-green-600" disabled>
                                    </div>
                                @else
                                    <div class="flex items-center text-red-600">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <input type="text" value="{{ $answer->answer }}" class="border-none bg-transparent text-red-600" disabled>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-gray-700">Correct Answer:</p>
                                        <p class="text-gray-600">{{ $answer->question->fill_in_the_blank->getCorrectAnswer() }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @break
            

                @default
            @endswitch
            {{-- @switch($record->excercise->type)
                    @case()
                        
                        @break
                
                    @default
                        
                @endswitch --}}
        </div>

        {{-- 
        @if ($record->feed)
        <div class="mt-6 rounded-lg p-4 bg-gradient-to-r from-blue-400 to-blue-600">
            <h2 class="text-lg font-semibold mb-2 uppercase text-white">Feedback:</h2>
            Rating: {{ $record->feed->rate }}

            <div class="text-4xl">
                @php
                    $ratingEmoji = '';
                    switch ($record->feed->rate) {
                        case 1:
                            $ratingEmoji = '😫'; // Difficult
                            break;
                        case 2:
                            $ratingEmoji = '😕'; // Moderately difficult
                            break;
                        case 3:
                            $ratingEmoji = '😐'; // Moderate
                            break;
                        case 4:
                            $ratingEmoji = '😊'; // Moderately easy
                            break;
                        case 5:
                            $ratingEmoji = '🙂'; // Easy
                            break;
                        default:
                            $ratingEmoji = '😐'; // Default to Moderate if not specified
                    }
                @endphp
                <span class="text-7xl text-white">{{ $ratingEmoji }}</span>
            </div>
            <div class="mt-4 text-lg text-gray-200">
                <p class="font-semibold">Message: {{ $record->feed->message }}</p>
            </div>
        </div>
    @endif --}}


        {{-- 
        <div class="mt-6 prose max-w-none border-b py-2 mb-6">
            Markdown content here
        </div> --}}
        {{-- 
        @foreach ($record->answers as $answer)
            <div class="mt-6">
                <div class="p-4 border rounded-md shadow-md">
                    <p class="flex items-center text-gray-700">
                        <span class="mr-auto"><strong>Question:</strong> {{ $answer->question->getNumber() }}. {{ $answer->question->question }}</span>

                        
                        {{$answer->compareUserAnswer()}}
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
                        <div class="mt-4 flex flex-wrap">
                            @foreach ($answer->question->multiple_choice->getShuffledOptionsAttribute() as $option)
                                <label class="inline-flex items-center mr-4 mb-2 text-gray-700">{{ $option }}</label>
                            @endforeach
                        </div>
                    @endif
                    <p class="text-gray-700">Actual Answer: {{ $answer->question->actual_answer }}</p>
                    <p class="text-gray-700">User Answer: {{ $answer->answer }}</p>
                </div>
            </div>
        @endforeach --}}

        <div class=" p-4 bg-gray-800 rounded-md text-white">
            <p>Total Score: {{ $record->getRealScore() }} / {{ $record->getTotalExerciseQuestions() }}</p>
        </div>
    </div>
</div>
