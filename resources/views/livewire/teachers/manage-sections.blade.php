<div>
    <x-main-layout>

        <form wire:submit="save">
            {{ $this->form }}
            
            <button type="submit">
                Submit
            </button>
        </form>
        
        <x-filament-actions::modals />
    </x-main-layout>
</div>
