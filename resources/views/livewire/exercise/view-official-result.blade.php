<div>




    <div class="bg-white rounded-md shadow-md p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900">Score Details</h1>

        </div>

        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-900">{{ $record->excercise->title }}</h2>
            <div class="flex items-center mt-2">
                <span class="text-blue-700 text-sm mr-2">Total Questions:
                    {{ $record->excercise->getTotalQuestions() }}</span>
                <span
                    class="inline-block px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">{{ $record->excercise->type }}</span>
            </div>
        </div>

        <div class="mt-6 border-t py-6">

            @switch($record->excercise->type)
                @case(\App\Models\Excercise::MULTIPLECHOICE)
                <div class="mt-6">
                    @foreach ($record->answers as $answer)
                        <div class="bg-white rounded-md shadow-md mb-6">
                            <div class="p-4 border-b">
                                <h2 class="text-lg font-semibold">Question {{ $answer->question->getNumber() }}</h2>
                            </div>
                            <div class="p-4">
                                <p class="text-gray-700">{{ $answer->question->question }}</p>
                            </div>
                            @foreach ($answer->question->multiple_choice->getShuffledOptionsAttribute() as $option)
                            @if ($answer->compareUserAnswer( $answer->question->multiple_choice->getCorrectAnswer() , $record->excercise->type )  == 'Correct')
                            <div class="p-4 border-t {{ $option === $answer->answer ? 'bg-green-50' : '' }}" action="#">
                            @elseif($answer->compareUserAnswer( $answer->question->multiple_choice->getCorrectAnswer() , $record->excercise->type )  == 'Wrong')
                            <div class="p-4 border-t {{ $option === $answer->answer ? 'bg-red-50' : '' }}" action="#">
                            @else  
                            <div class="p-4 border-t {{ $option === $answer->answer ? 'bg-white' : '' }}" action="#">
                            @endif
                                    <label class="flex items-center py-2">
                                        <input type="radio" name="answer_{{ $answer->question->id }}" value="{{ $option }}" class="mr-2 appearance-none hover:checked:bg-green-500 checked:bg-green-500"
                                            {{ $option === $answer->answer ? 'checked' : '' }}  disabled>
                                        <span   
                                        class="{{$answer->compareUserAnswer( $answer->question->multiple_choice->getCorrectAnswer() , $record->excercise->type )  == 'Correct'? 'text-green-600': ''}}">{{ $option }}</span>
                                    </label>
                                </div>
                                @endforeach
                                @if($answer->compareUserAnswer( $answer->question->multiple_choice->getCorrectAnswer() , $record->excercise->type )  == 'Wrong')
                            <div class="p-4 border-t">
                                <div class="">
                                    <p class="text-gray-700 ">Correct Answer</p>
                                    <div class="mt-6">
                                        <input type="radio"  class="checked:bg-gray-400" name="correct_answer_{{ $answer->question->id }}" value="{{ $answer->question->multiple_choice->getCorrectAnswer() }}" checked>
                                        <label class="text-gray-600  ml-2" for="correct_answer">{{ $answer->question->multiple_choice->getCorrectAnswer() }}</label>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                @break

                @case(\App\Models\Excercise::TRUE_OR_FALSE)
                    true or false
                @break

                @case(\App\Models\Excercise::FILL_IN_THE_BLANK)
                    fill in the blacnk
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

        <div class="mt-6 p-4 bg-gray-800 rounded-md text-white">
            <p>Total Score: {{ $record->getRealScore() }} / {{ $record->getTotalExerciseQuestions() }}</p>
        </div>
    </div>
</div>
