<div>


    <div class="px-4 py-5 sm:px-6 mb-4 ">
        <div class="-ml-4 -mt-2 flex flex-wrap items-center justify-between sm:flex-nowrap">
          <div class="ml-4 mt-2">
            <h1 class="text-xl font-semibold leading-6 text-system-900">

                {{$record->title}}

            </h1>
          </div>
          <div class="ml-4 mt-2 flex-shrink-0">

            <x-back-button :url="route('list-lessons')">
              BACK
          </x-back-button>
          </div>
        </div>
      </div>

    <form wire:submit="save">
        {{ $this->form }}

        <x-system-button type="submit" class="mt-4">
            Save Update
        </x-system-button>
    </form>

    <x-filament-actions::modals />
</div>
