<div>
    <form wire:submit="create">
        {{ $this->form }}

        <x-system-button type="submit" class="mt-6">
            Submit
        </x-system-button>
    </form>

    <x-filament-actions::modals />
</div>
