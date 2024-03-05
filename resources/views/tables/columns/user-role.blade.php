<div class="text-sm uppercase text-center">
    @if ($record = $getRecord())
        @switch($record->role)
            @case('Teacher')
                @if ($record->teacher)
                    <p class="text-green-500">Assigned Teacher</p>
                @else
                    <p class="text-gray-500">Teacher Not Assigned</p>
                @endif
                @break
            @case('Student')
                @if ($record->student)
                    <p class="text-green-500">Student Enrolled</p>
                @else
                    <p class="text-gray-500">Student Not Enrolled</p>
                @endif
                @break
            @default
        @endswitch
    @endif
</div>
