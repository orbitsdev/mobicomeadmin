<div>

    <div class="mb-5 flex justify-end">

        <x-back-button :url="URL::previous()">
            BACK
        </x-back-button>
    </div>
    <form wire:submit="save">
        {{ $this->form }}

        <x-system-button type="submit" class="mt-6">
            Save 
        </x-system-button>
    </form>

    <x-filament-actions::modals />
</div>
