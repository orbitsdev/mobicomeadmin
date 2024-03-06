<div class="">
        <h1 class="text-2xl font-semibold text-system-700 mb-4">
            {{ $record->user->getFullName() }}
        </h1>

        <div class="flex justify-end mb-4">
            <x-back-button :url="route('list-teachers')">
                BACK
            </x-back-button>
        </div>

        {{ $this->table }}
</div>
