<x-custom-layout>
    <div class="bg-white">
        <!-- Header -->

        <main class="isolate">
            <!-- Unauthorized Content Section -->
            <div class="py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">You are not authorized to access this page.</h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600">Please contact your administrator for further assistance.</p>


                        @auth

                        <form method="POST" action="{{ route('logout') }}" >
                            @csrf

                            <x-system-button type="submit" class="mt-4">
                                LOGOUT
                            </x-system-button>
                        </form>

                        @endauth
                        @guest

                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go to Home</a>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-custom-layout>
