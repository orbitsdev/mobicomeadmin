<div class=" ">
    <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
        <div class="ml-4 mt-2">
            <h1 class="text-xl font-semibold leading-6 text-system-900">
                {{-- {{$record->title}} --}}
            </h1>
        </div>
        <div class="ml-4 mt-2 flex-shrink-0">
            <x-back-button :url="route('list-excercises')">BACK</x-back-button>
        </div>
    </div>

    <div class="px-4 py-5 sm:px-6 mb-4 bg-white mt-4 ">


        <div class="white">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-3xl font-bold text-gray-900">{{ $record->title }}</h2>
                <div class="flex items-center mt-2">
                    <span class="text-blue-700 ml-2 text-sm mr-2">Total {{ $record->getTotalQuestions() }}</span>
                    <span class="inline-block px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">{{ $record->type }}</span>
                </div>
            </div>

            <div class="mt-2 prose max-w-none  border-b  py-2 mb-6">
                @markdown($record->description)
            </div>
        </div>

        @foreach ($record->questions as $question)
            <div class="mt-4">
                <h2 class="text-base font-medium leading-7 text-gray-700">{{ $question->getNumber() }}. {{ $question->question }}</h2>
                <div class="mt-2 space-y-10">
                    <fieldset class="flex">
                        @switch($question->excercise->type)
                            @case('Multiple Choice')
                                @foreach ($question->multiple_choice->getShuffledOptionsAttribute() as $key => $option)
                                    <div class="space-y-2">
                                        <div class="relative flex gap-x-3">
                                            <div class="flex h-6 items-center"></div>
                                            <div class="text-sm leading-6">
                                                @if($question->multiple_choice->getCorrectAnswer() == $option)
                                                <p class="text-green-500">
                                                    ({{ $option }})
                                                </p>
                                                @else
                                                <p class="text-gray-500">
                                                    {{ $option }}
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @break

                            @case('True or False')
                                <div class="text-base">
                                    <p class=" p-2 rounded-lg  text-gray-600">
                                        {{ $question->true_or_false->getTextAnswer() }}
                                    </p>
                                </div>
                            @break
                            @case('Fill in the Blank')
                                <span>
                                    {{ $question->fill_in_the_blank->getCorrectAnswer() }}
                                </span>
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

