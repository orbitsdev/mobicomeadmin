<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div class=" ">
        <table class=" divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Section Name
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Total Students
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200 w-full">

            @foreach ($getRecord()->enrolled_sections as $enrolled_section )
                  
         
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">
                        {{$enrolled_section->section->title}}
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900"> {{$enrolled_section->getTotalStudent()}}</div>
              </td>
            </tr>
            @endforeach
           
        
          </tbody>
        </table>
      </div>
      
</x-dynamic-component>
