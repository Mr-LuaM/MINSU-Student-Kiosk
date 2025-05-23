<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2 bg-primary text-white border border-transparent 
                rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-accent 
                focus:bg-accent active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-primary 
                focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>