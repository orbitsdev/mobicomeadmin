<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    
    <div>

        <div class="grid grid-cols-3">
            <div class="col-span-1">
                <a href="{{$getRecord()->user->getImage()}}" target="_blank" class="h-96 bg-gray-50 rounded">
                    <div class="w-full flex items-center justify-center">
                      <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg bg-gray-50">
                          <img src="{{$getRecord()->user->getImage()}}" alt="Off-white t-shirt with circular dot illustration on the front of mountain ridges that fade." class="object-cover object-center">
                        </div>
                    </div>
                  </a>
            </div>
          <dl class="col-span-2 divide-y divide-gray-100">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$getRecord()->user->getFullName()}}
              </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Email</dt>
            
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$getRecord()->user->email ?? ''}}
              </dd>

            </div>
            
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Role</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$getRecord()->user->role ?? ''}}
              </dd>
            </div>
            @if($getRecord()->user->student)
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Role</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$getRecord()->user->student->enrolled_section->section->title ?? ''}}
              </dd>
            </div>
            @endif

         
          

          </dl>
        </div>
      </div>
       
</x-dynamic-component>
