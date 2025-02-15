<button {{ $attributes->merge([
    'type' => 'button',
    'class' => 'inline-flex items-center px-4 py-2 bg-white border border-primary 
                rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest 
                shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 
                focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800 
                disabled:opacity-25 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>