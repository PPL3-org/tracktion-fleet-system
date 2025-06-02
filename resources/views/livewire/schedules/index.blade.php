<div x-data="{ sidebarOpen: false }"
    x-on:toggle.window="sidebarOpen = !sidebarOpen"
    class="flex flex-col w-full translate-all duration-300"
    x-bind:class="sidebarOpen ? 'ml-[16.6%]' : 'ml-0'"
    x-bind:style="sidebarOpen ? 'width: calc(100% - 16.6%)' : 'width: 100%'">
     
    <x-page-menu>
    <div>
        <span class="text-2xl text-white font-sans font-semibold">Jadwal Pengiriman</span>
    </div>

    <div class="flex justify-around gap-3.5">
        <x-button style='white' >
            Tambah Jadwal
        </x-button>

        <x-button style='green'>Cetak .xlsx</x-button>
    </div>
    </x-page-menu>
    
    <livewire:schedules.tables lazy />
 </div>