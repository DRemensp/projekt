<button
    wire:click="logout"
    class="flex items-center space-x-1 px-4 py-2 bg-red-600 hover:bg-red-700
           text-white rounded-md transition-colors duration-200"
>
    <!-- Logout Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
    </svg>
    <span>{{ __('Log Out') }}</span>
</button>
