<div>
    <div class="max-w-7xl mx-auto flex justify-end">

        <div class="px-4 py-5 sm:px-6 mb-4 ">
            <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
              <div class="ml-4 mt-2">
                <h1 class="text-xl font-semibold leading-6 text-system-900">

                    {{-- {{$record->title}} --}}

                </h1>
              </div>
              <div class="ml-4 mt-2 flex-shrink-0">
                <x-back-button :url="route('lessons-list')">
                    BACK
                </x-back-button>
               

              </div>
            </div>
          </div>


    </div>
    <div class="max-w-7xl mx-auto bg-white p-8 rounded">
        <div class="relative">
            <div class="grid grid-cols-2 gap-6">

                @if ($record->videoExists())
                <div class="flex justify-center">
                    <div class="aspect-w-16 aspect-h-9 max-w-full">
                        <video class="object-cover rounded-md shadow-md h-96" controls>
                            <source src="{{ $record->getVideo() }}" type="{{ $record->video_type }}">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                    @else
                    <div></div>
                    @endif
                    @if ($record->imageExists())
                    <div>
                        <img src="{{ $record->getImage() }}" alt="Lesson image"
                        class="w-full h-96 object-cover rounded-lg shadow-md">
                    </div>
                    @endif
                </div>
            </div>
            <div class="mt-8 prose max-w-none ">
                @markdown($record->content)
            </div>
        </div>

    </div>
