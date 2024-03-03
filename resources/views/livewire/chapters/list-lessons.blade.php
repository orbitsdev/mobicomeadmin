<div>
    <div class="flex  items-center justify-between">
        <div class="text-xl text-gray-600">
           Chapter: {{$record->number()}}  {{$record->title}}
        </div>
        <x-back-button :url="route('list-chapters')"/>
    </div>

    {{ $this->table }}
</div>
