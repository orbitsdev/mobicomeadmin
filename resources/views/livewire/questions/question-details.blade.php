<div class=" mx-auto bg-white p-8 rounded">
    <div class="relative">
        <h1 class="text-2xl font-semibold mb-4">{{$record->excercise->title}}</h1>

        <div class="grid grid-cols-2 gap-6">
            <!-- Add content here if needed -->
        </div>

        <div class="mt-8 prose max-w-none">
            {!! $record->content !!}
        </div>
    </div>
</div>
