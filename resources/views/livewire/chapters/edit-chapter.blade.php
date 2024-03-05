<div>
    <div class="flex justify-end items-center mb-4">

        <x-back-button :url="route('list-chapters')">BACK</x-back-button>
    </div>
    <form wire:submit="save">
        {{ $this->form }}

        <x-system-button type="submit" class="mt-4">
            Submit
        </x-system-button>
    </form>

    <x-filament-actions::modals />
</div>
