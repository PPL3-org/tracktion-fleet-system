<header class="bg-white p-4 shadow-md flex justify-between items-center sticky z-10 top-0 transition-all duration-300">

    <button 
        x-data="{ open: false }"
        x-on:toggle.window = "open = !open"
        @click="$dispatch('toggle')"
        class="transition-all duration-300 bg-[var(--color-primary)] text-white py-2 px-3 rounded-xl shadow-md hover:bg-[var(--color-hover)]"
        x-bind:class="open ? 'opacity-0 invisible' : 'opacity-100 visible'"
    >
        ☰
    </button>
    
    @auth
    {{-- Area yang dapat diklik untuk membuka modal profil --}}
    <div class="flex flex-col text-right cursor-pointer" onclick="Livewire.dispatch('openProfileModal')">
        <div class="flex items-center justify-end">
            <span class="font-medium font-poppins text-sm">{{ Auth::user()->email }}</span>
            {{-- Ikon Edit SVG Minimalis --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2 text-gray-500 hover:text-gray-700 transition-colors duration-150">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
        </div>
        <span class="font-normal font-poppins text-sm text-[#64748B]">{{ Auth::user()->name }}</span>
    </div>
    @endauth

</header>