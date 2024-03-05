<div class=" mx-auto bg-white p-8 rounded">
    <div class="relative">
        <h1 class="text-2xl font-semibold mb-4">{{$record->excercise->title}}</h1>

        <p>
            {{$record->question}}
        </p>
        {{-- @dump($record->multiple_choice_question) --}}
        {{-- @foreach ($record->multiple_choice_question->options as $option)
        {{$option}}

        @endforeach --}}
        {{-- {{$record->excercise->type}} --}}
        {{-- <div class="grid grid-cols-2 gap-6">
            <!-- Add content here if needed -->
        </div> --}}


    </div>
</div>
