<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
  
       

        <div class="w-full">
            <table class=" divide-y divide-gray-200 w-full">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Exercise Name
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Type
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Total Questions
                  </th>
                 
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200 w-full">
    
                @foreach ($getRecord()->user->excercises as $exercise )
                      
             
                <tr>
                 
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500"> {{$exercise->title}}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500"> {{$exercise->type}}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="text-sm text-gray-500"> {{$exercise->getTotalQuestions()}}</div>
                  </td>
                </tr>
                @endforeach
               
            
              </tbody>
            </table>
          </div>
  
</x-dynamic-component>
