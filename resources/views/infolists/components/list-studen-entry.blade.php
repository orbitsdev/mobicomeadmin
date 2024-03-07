<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class="w-full">

       
            <table class=" divide-y divide-gray-200  w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Section
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Full Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Email
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 w-full">
                    @foreach ($getRecord()->students->groupBy('enrolled_section.section.title') as $key => $students)
                        <tr class="bg-gray-50">
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $key }}
                            </th>

                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                            </th>


                        </tr>
                        @foreach ($students as $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"> </div>
                                </td>
                                <td class="px-6 py-3 text-left text-xs  text-gray-500 uppercase tracking-wider">

                                    {{ $student->user->getFullName() }}

                                </td>
                                <td class="px-6 py-3 text-left text-xs  text-gray-500 uppercase tracking-wider">

                                    {{ $student->user->email }}

                                </td>

                            </tr>
                        @endforeach
                    @endforeach


                </tbody>
            </table>
        



    </div>
</x-dynamic-component>
