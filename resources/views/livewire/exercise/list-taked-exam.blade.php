<div>
    <div class="bg-white rounded-md shadow-md p-6 mb-6">
        <h1 class="text-2xl uppercase font-bold mb-4">
            {{ $record->title }} ({{ $record->type }} ) - {{ $record->getTotalQuestions() }} Questions
        </h1>
        
        <div class="border-t prose max-w-none py-2">
            @markdown($record->description)
        </div>
    </div>
    
    <div class="mt-6">

        {{ $this->table }}
    </div>
</div>
