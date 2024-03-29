<div>


    <div class="flex justify-end items-center mb-4">

        <x-back-button :url="route('list-chapters')">BACK</x-back-button>
    </div>

    <div class="white max-w-7xl mx-auto  ">
        <div class=" px-6 lg:px-8">
            <div class="mx-auto  lg:mx-0">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Chapter
                    {{ $record->number() }} : {{ $record->title }} </h2>

                {{-- <span
                    class="mt-2 inline-flex items-center gap-x-1.5 rounded-full bg-blue-100 px-1.5 py-1 text-xs font-medium text-blue-700">
                    <svg class="h-1.5 w-1.5 fill-blue-500" viewBox="0 0 6 6" aria-hidden="true">
                        <circle cx="3" cy="3" r="3" />
                    </svg>
                    {{$record->getTotalLessons()}} Lessons
                </span> --}}


                <div class="mt-8 prose max-w-none ">
                    @markdown($record->description)

                    @foreach ($record->lessons as $lesson )
                    {{-- <p class="font-bold">
                        {{$lesson->title}}
                    </p> --}}
                    @markdown($lesson->content)
                    @endforeach
                </div>


            </div>

        </div>
    </div>

</div>
