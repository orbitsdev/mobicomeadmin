<div>


    <div class="mb-4 flex justify-end">
        <x-back-button :url="route('teacher-list-sections',['record'=> $record->enrolled_section->teacher])">
            BACK
        </x-back-button>




      </div>
    {{ $this->table }}
</div>
