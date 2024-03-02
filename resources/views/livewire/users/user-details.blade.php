<div>

    {{-- {{$record}} --}}


    <div>

        <div class="border-t border-gray-100">
          <dl class="divide-y divide-gray-100">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->getFullName()}}
              </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Email</dt>
            
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->email ?? ''}}
              </dd>

            </div>
            
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Role</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->role ?? ''}}
              </dd>
            </div>

            <a href="{{$record->getImage()}}" target="_blank" class="h-96 bg-gray-50 rounded">
              <div class="w-full">
                  <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg bg-gray-50">
                      <img src="{{$record->getImage()}}" class="object-cover object-center h-full w-full">
                  </div>
              </div>
            </a>
          
          
           

          </dl>
        </div>
      </div>
      
</div>
