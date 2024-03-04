<div>


    <div class="flex  items-center justify-between">
        <div class="text-xl text-gray-600">
            {{$record->title}}
        </div>
        <div class="text-xl text-gray-600">
            {{$record->type}}
        </div>
        <x-back-button :url="route('list-excercises')"/>
    </div>
    {{ $this->table }}
</div>
