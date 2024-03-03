<div>



    <div class="white ">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Chapter
                    {{ $record->chapter_number }}: {{ $record->title }} </h2>

                <span
                    class="mt-2 inline-flex items-center gap-x-1.5 rounded-full bg-blue-100 px-1.5 py-1 text-xs font-medium text-blue-700">
                    <svg class="h-1.5 w-1.5 fill-blue-500" viewBox="0 0 6 6" aria-hidden="true">
                        <circle cx="3" cy="3" r="3" />
                    </svg>
                    {{$record->getTotalLessons()}} Lessons
                </span>
                <div class="chapter-description">
                    @markdown($record->description)
                </div>
                
            </div>

        </div>
    </div>

</div>
