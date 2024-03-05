<button {{ $attributes->merge([ 'class' => 'inline-flex items-center px-4 py-2 bg-system-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-system-700 focus:bg-system-700 active:bg-system-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
