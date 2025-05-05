<header class="bg-white p-4 shadow-md flex justify-between items-center sticky z-10 top-0 transition-all duration-300">

    <button 
        dusk="navbar"
        x-data="{ open: false }"
        x-on:toggle.window = "open = !open"
        @click="$dispatch('toggle')"
        class="transition-all duration-300 bg-[var(--color-primary)] text-white py-2 px-3 rounded-xl shadow-md hover:bg-[var(--color-hover)]"
        x-bind:class="open ? 'opacity-0 invisible' : 'opacity-100 visible'"
    >
        ☰
    </button>
    
    <div class="flex flex-col text-right">
        <span class="font-medium font-poppins text-sm"><a href="/profile"></a>{{ Auth::user()->email }}</span>
        <span class="font-normal font-poppins text-sm text-[#64748B]">{{ Auth::user()->name }}</span>
    </div>


</header>