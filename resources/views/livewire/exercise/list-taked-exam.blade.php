<div>
    <div class="bg-white rounded-md shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl uppercase font-bold">
                {{ $record->title }} ({{ $record->type }}) - {{ $record->getTotalQuestions() }} Questions
            </h1>
            <a href="{{ route('list-excercises') }}" class="text-blue-500 hover:text-blue-700">Back</a>
        </div>
        
        <div class="border-t prose max-w-none py-2">
            @markdown($record->description)
        </div>
    </div>
    
    <div class="mt-6">

        {{ $this->table }}
    </div>
</div>
