<div>

    <div class="mb-4 flex justify-end">
        <x-back-button :url="route('teacher-list-excercises')">
            BACK
        </x-back-button>

      </div>
    <form wire:submit="create">
        {{ $this->form }}

        <x-system-button type="submit" class="mt-6">
            Submit
        </x-system-button>
    </form>

    <x-filament-actions::modals />
</div>
